<?php

namespace Lotto\Enums;

use Lotto\Models\LottoRecord;

class LottoTypeRelate extends BaseEnum
{
    const CATEGORY = 'category';
    const DOW = 'dow';
    const DMY = 'dmY';
    const PROVINCE_TODAY = 'province_today';
    const PROVINCE_BY_DATE = 'province_by_date';

    protected function getLimitTime($lottoRecord)
    {
        return $lottoRecord->created_at;
    }
    public function addCondition($query, $lottoRecord, $lottoItem)
    {
        if ($this->getValue() == static::DOW) {
            $d = DayOfWeek::fromDate($lottoRecord->created_at);
            $dowMysql = $d->toDayOfWeekMysql();
            $query->whereRaw('DAYOFWEEK(lotto_records.created_at) = ' . $dowMysql);
        }
        if ($this->getValue() == static::PROVINCE_TODAY) {
            $query->where('lotto_item_id', $lottoItem->id);
        }
        $query->where('created_at', '<', $this->getLimitTime($lottoRecord));
    }

    public function retreiveLinkTarget($date, $lottoCategory, $lottoItem)
    {
        $fullCode = $date->format('Ymd');
        $q = LottoRecord::where("fullcode", $fullCode);
        if ($lottoItem) {
            $q->where('lotto_item_id', $lottoItem->id);
        }
        $lottoRecord = $q->first();
        if (!$lottoRecord) return '';

        switch ($this->getValue()) {
            case static::DOW:
            case static::CATEGORY:
            case static::DMY:
                return $lottoCategory->linkCustomDate($date);
            case static::PROVINCE_TODAY:
            case static::PROVINCE_BY_DATE:
                if (!$lottoItem) return "";
                return $lottoRecord->link($lottoItem->prefix_sub_link);
        }
    }
}
