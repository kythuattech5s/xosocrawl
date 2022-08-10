<?php
namespace App\Http\Controllers;

use App\Models\Logan;
use App\Models\LoganCategory;

class LoganCategoryController extends Controller
{	
    public function view($request, $route, $link){
        $currentItem = LoganCategory::slug($link)->act()->first();
        if ($currentItem == null) { abort(404); }
        $currentItem->updateCountView();
        if ($currentItem->id != 1) {
            $listLogan = Logan::get();
            $activeNumOfDay = (int)(request()->num_of_day ?? 10);
            $activeNumOfDay = $activeNumOfDay > 50 ? 50:$activeNumOfDay;
            $activeNumOfDay = $activeNumOfDay < 2 ? 2:$activeNumOfDay;
            $listItemLoganActive = $currentItem->logan()
                                                ->whereRaw('FIND_IN_SET(?, day_of_week)', [now()->dayOfWeek])
                                                ->get();
            return view('staticals.logan_categories.view',compact('currentItem','listLogan','activeNumOfDay','listItemLoganActive'));
        }else {
            dd('Éc éc');
        }
    }
}