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
    public function formatByType()
    {
        $type = $this->type;
        if ($type == 'thu-dow') {
            return str_replace('dow', $this->getCurrentDateOfWeek(), $type);
        } else {
            $now = now();
            return $now->format($this->type);
        }
    }
    private function getCurrentDateOfWeek()
    {
        $now = now();
        $currentDayOfWeek = $now->dayOfWeek;
        $currentDayOfWeek = $currentDayOfWeek == 0 ? $currentDayOfWeek + 8 : $currentDayOfWeek + 1;
        return $currentDayOfWeek;
    }
}
