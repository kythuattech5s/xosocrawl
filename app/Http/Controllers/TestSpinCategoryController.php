<?php
namespace App\Http\Controllers;

use App\Models\TestSpin;
use App\Models\TestSpinCategory;

class TestSpinCategoryController extends Controller
{	
    public function view($request, $route, $link){
        $currentItem = TestSpinCategory::slug($link)->act()->first();
        if ($currentItem == null) { abort(404); }
        $currentItem->updateCountView();
        $listItemTestSpinCategory = TestSpinCategory::act()->get();
        $listActiveTestSpinToday = $currentItem->testSpin()
                                                ->whereRaw('FIND_IN_SET(?, day_of_week)', [now()->dayOfWeek])
                                                ->get();
        $listItems = $currentItem->testSpin()
                                ->act()
                                ->get();
        $dataTestSpin = TestSpin::buildDataSpinCate($currentItem);
        return view('test_spin_categories.view',compact('currentItem','listItems','listItemTestSpinCategory','listActiveTestSpinToday'));
    }
}