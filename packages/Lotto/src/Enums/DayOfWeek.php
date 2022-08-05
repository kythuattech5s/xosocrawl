<?php

namespace Lotto\Enums;

class DayOfWeek extends BaseEnum
{
    const THU_2 = 2;
    const THU_3 = 3;
    const THU_4 = 4;
    const THU_5 = 5;
    const THU_6 = 6;
    const THU_7 = 7;
    const CHU_NHAT = 8;

    public static function fromString($str)
    {
        $constList = static::getConstList();
        foreach ($constList as $key => $c) {
            $tmpKey = strtolower($key);
            $tmpKey = str_replace('_', '-', $tmpKey);
            if ($tmpKey == $str) {
                return $c;
            }
        }
        return 0;
    }
    public function toFullString()
    {
        switch ($this->getValue()) {
            case 8:
                return 'Chủ Nhật';
            case 2:
                return 'Thứ 2';
            case 3:
                return 'Thứ 3';
            case 4:
                return 'Thứ 4';
            case 5:
                return 'Thứ 5';
            case 6:
                return 'Thứ 6';
            case 7:
                return 'Thứ 7';
        }
    }
    public function toShortString()
    {
        switch ($this->getValue()) {
            case 8:
                return 'CN';
            case 2:
                return 'Thứ 2';
            case 3:
                return 'Thứ 3';
            case 4:
                return 'Thứ 4';
            case 5:
                return 'Thứ 5';
            case 6:
                return 'Thứ 6';
            case 7:
                return 'Thứ 7';
        }
    }
    public function slug()
    {
        return $this->getValue() < 8 ? 'thu-' . $this->getValue() : 'chu-nhat';
    }
    public static function fromDate($date): DayOfWeek
    {
        $dow = $date->format('w');
        $dow = $dow == 0 ? $dow + 8 : $dow + 1;
        return static::getByValue($dow);
    }
}
