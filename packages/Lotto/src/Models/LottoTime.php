<?php

namespace Lotto\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LottoTime extends BaseModel
{
    use HasFactory;
    private static $ALLTIMES;
    public static function allLottoTimes()
    {
        if (!static::$ALLTIMES) {
            static::$ALLTIMES = static::select('lotto_item_id', 'dayofweek', 'type')->get()->groupBy('lotto_item_id')->toArray();
        }
        return static::$ALLTIMES;
    }
}
