<?php

namespace Lotto\Enums;

class NoPrize extends BaseEnum
{
    const DAC_BIET = 0;
    const NHAT = 1;
    const NHI = 2;
    const BA = 3;
    const BON = 4;
    const NAM = 5;
    const SAU = 6;
    const BAY = 7;
    const TAM = 8;
    public static function getClassTr($prize)
    {
        switch ($prize) {
            case static::DAC_BIET:
                return 'db';
            case static::NHI:
            case static::BON:
            case static::SAU:
                return 'bg_ef';
            case static::BAY:
                return 'g7';
            default:
                return '';
        }
    }
}
