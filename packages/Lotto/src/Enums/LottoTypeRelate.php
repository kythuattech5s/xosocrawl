<?php

namespace Lotto\Enums;

class LottoTypeRelate extends BaseEnum
{
    const CATEGORY = 'category';
    const DOW = 'dow';
    const DMY = 'dmY';
    const PROVINCE_TODAY = 'province_today';

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
}
