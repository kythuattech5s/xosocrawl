<?php
namespace App\Http\Controllers;

use App\Models\TestSpin;
use App\Models\TestSpinCategory;

class TestSpinController extends Controller
{	
    public function view($request, $route, $link){
        if ($request->isMethod('post')) {
            if (isset($request->province_name)) {
                $provinceName = $request->province_name;
                if ($provinceName == 'mien-bac') {
                    $testSpinCategory = TestSpinCategory::find(1);
                    if (isset($testSpinCategory)) {
                        return redirect($testSpinCategory->slug);
                    }
                }else{
                    $testSpin = TestSpin::where('province_code',$provinceName)->first();
                    if (isset($testSpin)) {
                        return redirect($testSpin->slug);
                    }
                }
            }
        }
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
        $dataTestSpin = json_encode($currentItem->builDataSpin());
        return view('test_spins.view',compact('currentItem','listItems','listItemTestSpinCategory','listActiveTestSpinToday','dataTestSpin'));
    }
}