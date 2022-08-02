<?php

namespace Lotto\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Lotto\Enums\CrawlStatus;

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
        $record = static::where('code', $code)->where('lotto_item_id', $lottoItem->id)->first();
        if (!$record) {
            $now = now();
            $lottoTime = $lottoItem->lottoTimeByDate($date)->first();
            $record = new static;
            $record->code = $code;
            $record->fullcode = $fullcode;
            $record->created_at = $now;
            $record->updated_at = $now;
            $record->lotto_item_id = $lottoItem->id;
            $record->lotto_time_id = $lottoTime->id;
            $record->status = CrawlStatus::WAIT;
            $record->save();
        }
        return $record;
    }
    public function insertResults($results, $date)
    {
        $now = now();
        foreach ($results as $key => $rows) {
            foreach ($rows as $td) {
                $item = new LottoResultDetail();
                $item->lotto_record_id = $this->id;
                $item->lotto_item_id = $this->lotto_item_id;
                $item->created_at = $date;
                $item->updated_at = $date;
                $item->no_prize = $key;
                $item->number = $td;
                $item->save();
            }
        }
    }
}
