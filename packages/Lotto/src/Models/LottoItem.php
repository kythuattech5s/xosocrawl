<?php

namespace Lotto\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LottoItem extends BaseModel
{
    use HasFactory;

    public function hasResultToday()
    {
        $now = now();
        $currentDayOfWeek = $now->dayOfWeek;

        $currentDayOfWeek = $currentDayOfWeek == 0 ? $currentDayOfWeek + 8 : $currentDayOfWeek + 1;
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
}
