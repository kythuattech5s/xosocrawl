<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Lotto\Models\LottoItem;

class Logan extends BaseModel
{
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(LoganCategory::class,'logan_category_id');
    }
    public function lottoItem()
    {
        return $this->belongsTo(LottoItem::class);
    }
}