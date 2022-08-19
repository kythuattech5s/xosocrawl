<?php

namespace Lotto\Models;

use App\Models\BaseModel;
use App\Models\ProvinceMap;
use App\Models\StaticalCrawl;
use crawlmodule\basecrawler\Crawlers\BaseCrawler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Lotto\Helpers\LottoHelper;
use stdClass;
use Support;

class LottoItem extends BaseModel
{
    use HasFactory;

    public function hasResultToday()
    {
        $currentDayOfWeek = LottoHelper::getCurrentDateOfWeek(now());
        $times = LottoTime::allLottoTimes();
        $dayOfWeeks = $times[$this->id] ?? [];
        $days = array_filter($dayOfWeeks, function ($item) use ($currentDayOfWeek) {
            return $item['dayofweek'] == $currentDayOfWeek;
        });
        return count($days) > 0;
    }
    public function lottoTimes()
    {
        return $this->hasMany(LottoTime::class);
    }
    public function lottoTime()
    {
        return $this->hasOne(LottoTime::class);
    }
    public function currentLottoTime()
    {
        return $this->lottoTimeByDate(now());
    }
    public function lottoTimeByDate($date)
    {
        return $this->lottoTimes()->where('dayofweek', LottoHelper::getCurrentDateOfWeek($date));
    }
    public function lottoResultDetails()
    {
        return $this->hasMany(LottoResultDetail::class);
    }
    public function lottoRecords()
    {
        return $this->hasMany(LottoRecord::class);
    }
    public function lastLottoRecord()
    {
        return $this->hasOne(LottoRecord::class)->orderBy('created_at', 'desc');
    }
    public function lottoCategory()
    {
        return $this->belongsTo(LottoCategory::class);
    }
    public function buildLinkKetQua($date)
    {
        $code = Support::createShortCodeDay($date);
        return vsprintf($this->prefix_slug_segment, [$code, $code]);
    }
    public function testSpin()
    {
        return $this->belongsTo(TestSpin::class);
    }
    public function predictLotteryProvinceResult()
    {
        return $this->belongsTo(PredictLotteryProvinceResult::class);
    }
    public function getSlug()
    {
        if ($this->lotto_category_id != 3 && $this->lotto_category_id != 4) return $this->slug;
        $prefix = $this->prefix_sub_link;
        if (strlen($prefix) > 0) {
            return $prefix . '/' . $this->slug;
        }
        return $this->slug;
    }
    public function getImageStatus()
    {
        $times = LottoTime::allLottoTimes();
        $currentDayOfWeek = LottoHelper::getCurrentDateOfWeek(now());
        $dayOfWeeks = $times[$this->id] ?? [['hour_from' => 0, 'hour_to' => 0]];
        $days = array_filter($dayOfWeeks, function ($item) use ($currentDayOfWeek) {
            return $item['dayofweek'] == $currentDayOfWeek;
        });
        $day = count($days) > 0 ? array_shift($days) : ['hour_from' => 0, 'hour_to' => 0];
        $hourFrom = (int)$day['hour_from'];
        $hourTo = (int)$day['hour_to'];
        if ($hourFrom == 0 || $hourTo == 0) return '';
        $now = now();
        $hour = $now->hour;
        $minute = $now->minute;
        $totalMinute = $hour * 3600 + $minute * 60;
        $img = '<img alt="image status" class="" height="10" src="theme/frontend/images/%1$s"
        width="30">';
        if ($totalMinute >= $hourFrom && $totalMinute <= $hourTo) {
            return '<img alt="image status" class="" height="10" src="theme/frontend/images/rolling.gif"
            width="30">';
        } else if ($totalMinute > $hourTo) {
            return '<img alt="image status" class="" height="15" src="theme/frontend/images/done.png"
            width="15">';
        } else {
            return '<img alt="image status" class="" height="10" src="theme/frontend/images/waiting.gif"
            width="30">';
        }
    }
    public function getLogan()
    {
        return StaticalCrawl::where('type', 'tk_logan')->where('province_id', $this->province_map_id)->first();
    }
    public function createDataDirect($data,$time)
    {
        $fullcode = Support::timeToFullCode($time);
        $code = Support::createShortCode($time);
        $lottoRecord = LottoRecord::where('fullcode',$fullcode)
                                ->where('lotto_item_id',$this->id)
                                ->where('lotto_category_id',$this->lotto_category_id)
                                ->first();
        if (!isset($lottoRecord)) {
            $lottoRecord = new LottoRecord;
            $lottoRecord->fullcode = $fullcode;
            $lottoRecord->code = $code;
            $lottoRecord->created_at = $time;
            $lottoRecord->updated_at = $time;
            $lottoRecord->lotto_item_id = $this->id;
            $lottoRecord->lotto_category_id = $this->lotto_category_id;
            $lottoRecord->status = 3;
            $lotoTime = LottoTime::where('dayofweek',$time->dayOfWeek == 0 ? 8:$time->dayOfWeek+1)
                                ->where('lotto_item_id',$this->id)
                                ->where('lotto_category_id',$this->lotto_category_id)
                                ->first();
            if (isset($lotoTime)) {
                $lottoRecord->lotto_time_id = $lotoTime->id;
            }
            $lottoRecord->save();
        }
        $listItemDetail = $lottoRecord->lottoResultDetails()->get();
        foreach ($data as $no => $itemData) {
            if ($no == 'MaDb') {
                $lottoRecord->description = implode('-',$itemData);
                $lottoRecord->save();
            }else{
                $noPrize = $no == 'DB' ? 0:(int)$no;
                foreach ($itemData as $item) {
                    if ($item != '' && $item != '.') {
                        if (count($listItemDetail->where('no_prize',$noPrize)->where('number',$item)) == 0) {
                            $lottoResultDetail = new LottoResultDetail;
                            $lottoResultDetail->lotto_record_id = $lottoRecord->id;
                            $lottoResultDetail->lotto_item_id = $this->id;
                            $lottoResultDetail->created_at = $time;
                            $lottoResultDetail->updated_at = $time;
                            $lottoResultDetail->no_prize = $noPrize;
                            $lottoResultDetail->number = $item;
                            $lottoResultDetail->lotto_category_id = $this->lotto_category_id;
                            $lottoResultDetail->save();
                        }
                    }
                }
            }
        }
        $isFull = false;
        if ($this->lotto_category_id == 1) {
            $isFull = count($listItemDetail) >= array_sum(LottoRecord::getLotteDataMbFormat()) && count(explode('-',$lottoRecord->description)) >= 6;
        }else{
            $isFull = count($listItemDetail) >= array_sum(LottoRecord::getLotteDataMnFormat());
        }
        $newLottoRecordStatus = $isFull ? 1:3;
        if ($lottoRecord->status != $newLottoRecordStatus) {
            $lottoRecord->status = $newLottoRecordStatus;
            $lottoRecord->save();
        }
        return $isFull;
    }
    public function provinceMap()
    {
        return $this->belongsTo(ProvinceMap::class);
    }
    public function buildDataDirect($time)
    {
        if ($this->lotto_category_id == 1) {
            return $this->lottoCategory->buildDataDirect($time);
        }

        $lottoRecord = LottoRecord::where('lotto_category_id',$this->lotto_category_id)
                                ->where('lotto_item_id',$this->id)
                                ->where('fullcode',\Support::timeToFullCode($time))
                                ->first();
        if (!isset($lottoRecord)) {
            return [];
        }
        $provinceMap = $this->provinceMap ?? null;
        $ret = new stdClass;
        $ret->provinceCode = Str::upper(isset($provinceMap) ? $provinceMap->province_short_code:'');
        $ret->provinceName = isset($provinceMap) ? $provinceMap->name:'';
        $ret->rawData = "";
        $ret->tuong_thuat = true;
        $ret->isFull = $lottoRecord->isFull();
        $ret->isRolling = 1;
        $ret->resultDate = (int)floor(microtime(true) * 1000);
        $ret->dau = new stdClass;
        $ret->duoi = new stdClass;
        $ret->lotData = $lottoRecord->buildLottoDirectData();
        $ret->loto = [];
        return $ret;
    }
}
