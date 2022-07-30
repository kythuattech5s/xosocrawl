<?php
namespace App\Http\Controllers;
use App\Models\PredictLotteryResultCategory;

class PredictLotteryResultCategoryController extends Controller
{	
    public function view($request, $route, $link){
        $currentItem = PredictLotteryResultCategory::slug($link)->act()->first();
        if ($currentItem == null) { abort(404); }
        $currentItem->updateCountView();
        return view('predict_lottery_result_categories.view',compact('currentItem'));
    }
}