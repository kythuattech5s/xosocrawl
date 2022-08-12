<?php
namespace App\Http\Controllers;

use App\Models\Logan;
use App\Models\LoganCategory;
use ModuleStatical\Logan\ModuleStaticalLogan;
use ModuleStatical\Helpers\ModuleStaticalHelper;

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
            $activeNumOfDay = 10;
            $listLogan = $currentItem->logan()->act()->get();
            $time = ModuleStaticalHelper::getTimeTrungNam($currentItem->lotto_category_id)->addDays(1);
            $dataHtml = ModuleStaticalLogan::getStaticalData('logan_category',$time,$currentItem->id,$currentItem->real_link);
            return view('staticals.logan_categories.view',compact('currentItem','listLogan','activeNumOfDay','dataHtml'));
        }else {
            // $time = ModuleStaticalHelper::getTimeTrungNam($currentItem->lotto_category_id)->addDays(1);
            // $activeNumOfDay = 10;
            // $listLogan = $currentItem->logan()->act()->get();
            // $dataHtml = ModuleStaticalLogan::getStaticalData('logan_category',$time,$currentItem->id,$currentItem->real_link);
        }
    }
}