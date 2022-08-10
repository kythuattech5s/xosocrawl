<?php

namespace Lotto\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
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
    public function lottoResultDetails()
    {
        return $this->hasMany(LottoResultDetail::class);
    }
    public function lottoRecords()
    {
        return $this->hasMany(LottoRecord::class);
    }
    public function lastLottoRecord()
    {
        return $this->hasOne(LottoRecord::class)->orderBy('created_at', 'desc');
    }
    public function lottoCategory()
    {
        return $this->belongsTo(LottoCategory::class);
    }
    public function testSpin()
    {
        return $this->belongsTo(TestSpin::class);
    }
    public function predictLotteryProvinceResult()
    {
        return $this->belongsTo(PredictLotteryProvinceResult::class);
    }
    public function getSlug()
    {
        $prefix = $this->prefix_sub_link;
        if (strlen($prefix) > 0) {
            return $prefix . '/' . $this->slug;
        }
        return $this->slug;
    }
}
