<?php
namespace App\Http\Controllers;

use App\Models\PredictLotteryResult;

class PredictLotteryResultController extends Controller
{	
    public function view($request, $route, $link){
        $currentItem = PredictLotteryResult::with('category')->slug($link)->act()->first();
        if ($currentItem == null) { abort(404); }
        $currentItem->updateCountView();
        return view('predict_lottery_result.view',compact('currentItem'));
    }
}