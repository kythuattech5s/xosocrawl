<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Lotto\Models\LottoCategory;

class XosoTrucTiepItem extends BaseModel
{
    use HasFactory;
    public function lottoCategory()
    {
        return $this->belongsTo(LottoCategory::class);
    }
}