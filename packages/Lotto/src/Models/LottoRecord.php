<?php

namespace Lotto\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Lotto\Dtos\HeadTail;
use Lotto\Enums\CrawlStatus;
use Lotto\Enums\DayOfWeek;

class LottoRecord extends BaseModel
{
    use HasFactory;

    public static function getCurrentRecord($lottoItem)
    {
        return static::getRecordByDate($lottoItem, now());
    }
    public static function getRecordByDate($lottoItem, $date)
    {
        $code = $date->format('Ynj');
        $fullcode = $date->format('Ymd');
        $record = static::where('fullcode', $fullcode)->where('lotto_item_id', $lottoItem->id)->first();
        if (!$record) {
            $now = now();
            $lottoTime = $lottoItem->lottoTimeByDate($date)->first();
            $record = new static;
            $record->code = $code;
            $record->fullcode = $fullcode;
            $record->created_at = $date;
            $record->updated_at = $now;
            $record->lotto_item_id = $lottoItem->id;
            $record->lotto_category_id = $lottoItem->lotto_category_id;
            $record->lotto_time_id = $lottoTime->id;
            $record->status = CrawlStatus::WAIT;
            $record->save();
        }
        return $record;
    }
    public function insertResults($results, $date)
    {
        foreach ($results as $key => $rows) {
            foreach ($rows as $td) {
                $item = new LottoResultDetail();
                $item->lotto_record_id = $this->id;
                $item->lotto_item_id = $this->lotto_item_id;
                $item->lotto_category_id = $this->lotto_category_id;
                $item->created_at = $date;
                $item->updated_at = $date;
                $item->no_prize = $key;
                $item->number = $td;
                $item->save();
            }
        }
    }

    public function dayOfWeek()
    {
        return DayOfWeek::fromDate($this->created_at);
    }
    public function currentDayOfWeek()
    {
        $d = DayOfWeek::fromDate($this->created_at);
        return $d->getValue();
    }

    public function lottoResultDetails()
    {
        return $this->hasMany(LottoResultDetail::class);
    }
    public function lottoItem()
    {
        return $this->belongsTo(LottoItem::class);
    }
    public function prev($checkLottoItem = true, $dow = false, $limit = 1)
    {
        $q = static::select("lotto_records.*");
        if ($dow) {
            $d = DayOfWeek::fromDate($this->created_at);
            $dowMysql = $d->toDayOfWeekMysql();
            $q->whereRaw('DAYOFWEEK(lotto_records.created_at) = ' . $dowMysql);
        }
        $createdAt = $this->created_at;
        $createdAt->hour = 0;
        $createdAt->minute = 0;
        $createdAt->second = 0;
        $q->where('lotto_records.created_at', '<', $createdAt)->where('lotto_records.lotto_category_id', $this->lotto_category_id);
        if ($checkLottoItem) {
            $q->where('lotto_records.lotto_item_id', $this->lotto_item_id);
        }
        $q->orderBy('lotto_records.created_at', 'desc');
        if ($limit == 1) {
            return $q->limit(1)->first();
        } else {
            return $q->limit($limit)->get();
        }
    }
    public function next($checkLottoItem = true)
    {
        $q = static::where('created_at', '>', $this->created_at)->where('lotto_category_id', $this->lotto_category_id);
        if ($checkLottoItem) {
            $q = $q->where('lotto_item_id', $this->lotto_item_id);
        }
        return $q->orderBy('created_at', 'asc')->limit(1)->first();
    }
    public function link($prefix = null)
    {
        $paramPrints = [];
        if (isset($prefix) && $prefix != '') {
            $paramPrints[] = $prefix;
        }
        $lottoTime = $this->lottoItem->lottoTime;
        $slugDate = $this->lottoItem->slug_date;
        $count = substr_count($slugDate, "%s");
        $params = array_fill(0, $count, $lottoTime->formatByType($this->created_at));
        $link = vsprintf($slugDate, $params);
        $paramPrints[] = $link;
        return implode('/', $paramPrints);
    }
    public function linkWithFormat($format)
    {
        $f = $format['format'];
        $slug = $format['slug'];
        if ($f == 'thu-dow') {
            $d = DayOfWeek::fromDate($this->created_at);
            $slug = vsprintf($slug, [$d->slug()]);
        } else {
            $slug = vsprintf($slug, [$this->created_at->format($f)]);
        }
        return $slug;
    }
    public function lottoTimes()
    {
        return $this->belongsTo(LottoTime::class, 'lotto_time_id');
    }
    public function headTail()
    {
        return new HeadTail($this->lottoResultDetails);
    }
}
