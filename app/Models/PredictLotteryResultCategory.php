<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class PredictLotteryResultCategory extends BaseModel
{
    use HasFactory;
    public function predictLotteryResult()
    {
        return $this->hasMany(PredictLotteryResult::class,'predict_lottery_result_category_id');
    }
}