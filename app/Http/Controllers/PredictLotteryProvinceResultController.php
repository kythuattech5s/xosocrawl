<?php
namespace App\Http\Controllers;

use App\Models\PredictLotteryProvinceResult;
use App\Models\PredictLotteryResultCategory;

class PredictLotteryProvinceResultController extends Controller
{	
    public function view($request, $route, $link){
        $currentItem = PredictLotteryProvinceResult::with('category')->slug($link)->act()->first();
        if ($currentItem == null) { abort(404); }
        $currentItem->updateCountView();
        $listDifferent = PredictLotteryProvinceResult::act()->where('show_sidebar',1)->where('id','!=',$currentItem->id)->get();
        $listPredictLotteryResultCategory = PredictLotteryResultCategory::get();
        return view('predict_lottery_province_result.view',compact('currentItem','listDifferent','listPredictLotteryResultCategory'));
    }
}