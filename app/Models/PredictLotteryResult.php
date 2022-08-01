<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class PredictLotteryResult extends BaseModel
{
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(PredictLotteryResultCategory::class,'predict_lottery_result_category_id');
    }
}