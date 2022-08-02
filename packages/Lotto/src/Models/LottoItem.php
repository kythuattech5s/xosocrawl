<?php

namespace Lotto\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Lotto\Helpers\LottoHelper;

class LottoItem extends BaseModel
{
    use HasFactory;

    public function hasResultToday()
    {
        $currentDayOfWeek = LottoHelper::getCurrentDateOfWeek(now());
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
    public function lottoTime()
    {
        return $this->hasOne(LottoTime::class);
    }
    public function currentLottoTime()
    {
        return $this->lottoTimeByDate(now());
    }
    public function lottoTimeByDate($date)
    {
        return $this->lottoTimes()->where('dayofweek', LottoHelper::getCurrentDateOfWeek($date));
    }
}
