<?php
namespace App\Http\Controllers;

use App\Models\Logan;
use App\Models\LoganCategory;

class LoganController extends Controller
{	
    public function view($request, $route, $link){
        if ($request->isMethod('post')) {
            if (isset($request->province)) {
                $provinceName = $request->province;
                if ($provinceName == 'mien-bac') {
                    $testSpinCategory = LoganCategory::find(1);
                    if (isset($testSpinCategory)) {
                        return redirect($testSpinCategory->slug);
                    }
                }else{
                    $testSpin = Logan::where('province_code',$provinceName)->first();
                    if (isset($testSpin)) {
                        return redirect($testSpin->slug)->with('num_of_day',$request->num_of_day);
                    }
                }
            }
        }
        $currentItem = Logan::slug($link)->whereHas('category')->with('lottoItem')->with('category')->act()->first();
        if ($currentItem == null) { abort(404); }
        $currentItem->updateCountView();
        $listLogan = $currentItem->category->logan()->get();
        $activeNumOfDay = (int)(session()->get('num_of_day') ?? 10);
        $activeNumOfDay = $activeNumOfDay > 50 ? 50:$activeNumOfDay;
        $activeNumOfDay = $activeNumOfDay < 2 ? 2:$activeNumOfDay;
        return view('staticals.logans.view',compact('currentItem','listLogan','activeNumOfDay'));
    }
}