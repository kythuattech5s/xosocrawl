<?php

namespace Lotto\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Lotto\Helpers\LottoHelper;

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
    public function formatByType($date)
    {
        $date = isset($date) ? $date : now();
        $type = $this->type;
        if ($type == 'thu-dow') {
            return str_replace('dow', LottoHelper::getCurrentDateOfWeek($date), $type);
        } else {
            return $date->format($this->type);
        }
    }
}
