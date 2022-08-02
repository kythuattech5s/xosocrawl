<?php

namespace Lotto\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
}
