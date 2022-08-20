<?php

namespace Lotto\Models;

use App\Models\BaseModel;
use App\Models\PredictLotteryResult;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Lotto\Enums\CrawlStatus;
use Lotto\Enums\DayOfWeek;
use Lotto\Helpers\LottoHelper;
use stdClass;

class LottoCategory extends BaseModel
{
    use HasFactory;
    public function lottoItems()
    {
        return $this->hasMany(LottoItem::class);
    }
    public function lottoRecords()
    {
        return $this->hasMany(LottoRecord::class);
    }
    public function lottoTodayItems($dow = -1)
    {
        $dow  = $dow > 0 ? $dow : LottoHelper::getCurrentDateOfWeek();
        return $this->lottoItems()->select('lotto_items.*')->join('lotto_times', function ($join) {
            $join->on('lotto_items.id', '=', 'lotto_times.lotto_item_id');
        })->where('lotto_times.dayofweek', $dow)->get();

        // return $this->lottoItems()->whereHas('lottoTimes', function ($q) use ($dow) {
        //     $q->where('lotto_times.dayofweek', $dow);
        // })->get();
    }
    public function lottoNearestItem($limit = 1)
    {
        $currentDayOfWeek = LottoHelper::getCurrentDateOfWeek();
        return $this->lottoItems()->select(DB::raw('lotto_items.*, lotto_times.dayofweek dow'))->join('lotto_times', function ($join) {
            $join->on('lotto_items.id', '=', 'lotto_times.lotto_item_id');
        })
            ->join('lotto_records', function ($join) {
                $join->on('lotto_items.id', '=', 'lotto_records.lotto_item_id');
            })
            ->where('lotto_records.status', CrawlStatus::SUCCESS)
            ->orderBy('lotto_records.created_at', 'desc')
            ->orderByRaw('ABS(' . $currentDayOfWeek . '-lotto_times.dayofweek)')->limit($limit)->get();
    }
    public function linkDate($lottoRecord)
    {

        $slugDate = $this->slug_with_date;
        $link = vsprintf($slugDate, [$lottoRecord->created_at->format('j-n-Y')]);
        return $link;
    }
    public function linkDayOfWeek($lottoRecord, $forceDay = -1)
    {
        $slugDate = $this->slug_with_dayofweek;
        if ($forceDay < 0) {
            $forceDay = LottoHelper::getCurrentDateOfWeek($lottoRecord->created_at);
        }
        $params = [$forceDay < 8 ? 'thu-' . $forceDay : 'chu-nhat'];


        $link = vsprintf($slugDate, $params);
        return $link;
    }
    public function linkCustomDate($date)
    {

        $slugDate = $this->slug_with_date;
        $link = vsprintf($slugDate, [$date->format('j-n-Y')]);
        return $link;
    }
    public function getContentDow($lottoRecord, $isMienNam = false)
    {
        if (!$isMienNam) {
            $d = DayOfWeek::fromDate($lottoRecord->created_at);
            return vsprintf($this->content_dow, [$d->toFullString(), $d->slug()]);
        } else {
            $d = DayOfWeek::fromDate($lottoRecord->created_at);
            $lottoItemTodays = $this->lottoTodayItems($d->getValue());
            $str = '';
            foreach ($lottoItemTodays as $key => $lottoItem) {
                $str .= '<p dir="ltr">
                <span style="font-size:14px">- <a href="' . $lottoItem->prefix_sub_link . '/' . $lottoItem->slug . '" title="Xổ số ' . $lottoItem->name . '">
                    <span style="color:#FF0000">
                      <strong>Xổ số ' . $lottoItem->name . '</strong>
                    </span>
                  </a>
                </span>
              </p>';
            }
            $d = DayOfWeek::fromDate($lottoRecord->created_at);
            return vsprintf($this->content_dow, [$d->toFullString(), $d->slug(), $str]);
        }
    }
    public function getPredictNews()
    {
        return PredictLotteryResult::where('predict_lottery_result_category_id', $this->predict_lottery_result_category_id)->limit(3)->orderBy('id', 'desc')->get();
    }
    public function buildDataDirect($time)
    {
        if ($this->id == 1) {
            $lottoRecord = LottoRecord::where('lotto_category_id', $this->id)->where('fullcode', \Support::timeToFullCode($time))->first();
            if (!isset($lottoRecord)) {
                return [];
            }
            $ret = new stdClass;
            $ret->provinceCode = "MB";
            $ret->provinceName = "";
            $ret->rawData = "";
            $ret->tuong_thuat = true;
            $ret->isRolling = 1;
            $ret->resultDate = (int)floor(microtime(true) * 1000);
            $ret->dau = new stdClass;
            $ret->duoi = new stdClass;
            $ret->lotData = $lottoRecord->buildLottoDirectData();
            $ret->loto = [];
            return $ret;
        }
        $timeShow = $time->dayOfWeek == 0 ? 8 : $time->dayOfWeek + 1;
        $lottoItems = LottoItem::where('lotto_category_id', $this->id)->whereRaw('FIND_IN_SET(?,time_show)', [$timeShow])->get();
        $ret = [];
        foreach ($lottoItems as $lottoItem) {
            array_push($ret, $lottoItem->buildDataDirect($time));
        }
        return $ret;
    }
    public function isInRollingTime()
    {
        $now = now();
        $second = $now->hour * 3600 + $now->minute * 60;
        $hour = 0;
        if ($this->id = 1) {
            $hour = 18;
        }
        if ($this->id = 3) {
            $hour = 16;
        }
        if ($this->id = 4) {
            $hour = 17;
        }
        $mb = $hour * 3600 + 10 * 60;
        $add = 30 * 60;
        if ($hour == 0) return false;
        if ($second > $mb && $second < $mb + $add) {
            return true;
        } else {
            return false;
        }
    }
}
