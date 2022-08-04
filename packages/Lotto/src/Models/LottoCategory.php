<?php

namespace Lotto\Models;

use App\Models\BaseModel;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Lotto\Enums\CrawlStatus;
use Lotto\Helpers\LottoHelper;

class LottoCategory extends BaseModel
{
    use HasFactory;
    public function lottoItems()
    {
        return $this->hasMany(LottoItem::class);
    }
    public function lottoTodayItems()
    {
        return $this->lottoItems()->join('lotto_times', function ($join) {
            $join->on('lotto_items.id', '=', 'lotto_times.lotto_item_id');
        })->where('lotto_times.dayofweek', LottoHelper::getCurrentDateOfWeek())->get();
    }
    public function lottoNearestItem()
    {
        $currentDayOfWeek = LottoHelper::getCurrentDateOfWeek();
        return $this->lottoItems()->select(DB::raw('lotto_items.*'))->join('lotto_times', function ($join) {
            $join->on('lotto_items.id', '=', 'lotto_times.lotto_item_id');
        })
            ->join('lotto_records', function ($join) {
                $join->on('lotto_items.id', '=', 'lotto_records.lotto_item_id');
            })
            ->where('lotto_records.status', CrawlStatus::SUCCESS)
            ->orderBy('lotto_records.created_at', 'desc')
            ->orderByRaw('ABS(' . $currentDayOfWeek . '-lotto_times.dayofweek)')->limit(1)->get();
    }
    public function linkDate($lottoRecord)
    {

        $slugDate = $this->slug_with_date;
        $link = vsprintf($slugDate, [$lottoRecord->created_at->format('j-n-Y')]);
        return $link;
    }
    public function linkDayOfWeek($lottoRecord, $forceDay = -1)
    {
        $slugDate = $this->slug_with_dayofweek;
        if ($forceDay < 0) {
            $params = [LottoHelper::getCurrentDateOfWeek($lottoRecord->created_at)];
        } else {
            $params = [$forceDay < 8 ? 'thu-' . $forceDay : 'chu-nhat'];
        }

        $link = vsprintf($slugDate, $params);
        return $link;
    }
}
