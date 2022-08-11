<?php
namespace App\Http\Controllers;

use App\Models\Logan;
use App\Models\LoganCategory;

class LoganCategoryController extends Controller
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
        $currentItem = LoganCategory::slug($link)->act()->first();
        if ($currentItem == null) { abort(404); }
        $currentItem->updateCountView();
        if ($currentItem->id != 1) {
            $listLogan = $currentItem->logan()->get();
            $activeNumOfDay = 10;
            $listItemLoganActive = $currentItem->logan()
                                                ->with('lottoItem')
                                                ->whereRaw('FIND_IN_SET(?, day_of_week)', [now()->dayOfWeek])
                                                ->get();
            return view('staticals.logan_categories.view',compact('currentItem','listLogan','activeNumOfDay','listItemLoganActive'));
        }else {
            dd('Éc éc');
        }
    }
}