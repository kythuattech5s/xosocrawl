<?php
namespace App\Http\Controllers;

use App\Models\TestSpin;
use App\Models\TestSpinCategory;

class TestSpinController extends Controller
{	
    public function view($request, $route, $link){
        $currentItem = TestSpin::slug($link)->whereHas('category')->with('category')->act()->first();
        if ($currentItem == null) { abort(404); }
        $currentItem->updateCountView();
        $listItemTestSpinCategory = TestSpinCategory::act()->get();
        $listActiveTestSpinToday = $currentItem->category->testSpin()
                                                        ->whereRaw('FIND_IN_SET(?, day_of_week)', [now()->dayOfWeek])
                                                        ->get();
        $listItems = $currentItem->category->testSpin()
                                            ->act()
                                            ->get();
        return view('test_spins.view',compact('currentItem','listItems','listItemTestSpinCategory','listActiveTestSpinToday'));
    }
}