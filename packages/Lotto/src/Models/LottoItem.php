<?php

namespace Lotto\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Lotto\Helpers\LottoHelper;
use Support;

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
    public function buildLinkKetQua($date)
    {
        $code = Support::createShortCodeDay($date);
        return vsprintf($this->prefix_slug_segment,[$code,$code]);
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
    public function getImageStatus()
    {
        $times = LottoTime::allLottoTimes();
        $currentDayOfWeek = LottoHelper::getCurrentDateOfWeek(now());
        $dayOfWeeks = $times[$this->id] ?? ['hour_from' => 0, 'hour_to' => 0];
        $days = array_filter($dayOfWeeks, function ($item) use ($currentDayOfWeek) {
            return $item['dayofweek'] == $currentDayOfWeek;
        });
        if (!isset($days[0])) {
            return false;
        }
        $day = $days[0];
        $hourFrom = (int)$day['hour_from'];
        $hourTo = (int)$day['hour_to'];
        if ($hourFrom == 0 || $hourTo == 0) return '';
        $now = now();
        $hour = $now->hour;
        $minute = $now->minute;
        $totalMinute = $hour * 3600 + $minute * 60;
        $img = '<img alt="image status" class="" height="10" src="theme/frontend/images/%1$s"
        width="30">';
        if ($totalMinute >= $hourFrom && $totalMinute <= $hourTo) {
            return '<img alt="image status" class="" height="10" src="theme/frontend/images/rolling.gif"
            width="30">';
        } else if ($totalMinute > $hourTo) {
            return '<img alt="image status" class="" height="15" src="theme/frontend/images/done.png"
            width="15">';
        } else {
            return '<img alt="image status" class="" height="10" src="theme/frontend/images/waiting.gif"
            width="30">';
        }
    }
}
