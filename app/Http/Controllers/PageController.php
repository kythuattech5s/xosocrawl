<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\DreamNumberDecoding;
use App\Models\Page;
use App\Models\PredictLotteryResultCategory;
use App\Models\TestSpin;
use App\Models\TestSpinCategory;
use DB;
use Cache;

class PageController extends Controller
{
    public function view($request, $route, $link)
    {
        $currentItem = Page::slug($link)->act()->first();
        if (!isset($currentItem)) {
            abort(404);
        }
        $currentItem->updateCountView();
        if ($currentItem->layout_show == 'dream_number_decodings') {
            return $this->viewPageAllDreamNumberDecoding($request,$currentItem);
        }
        if ($currentItem->layout_show == 'all_predict_the_outcome') {
            return $this->viewPageAllRredictTheOutCome($request,$currentItem);
        }
        if ($currentItem->layout_show == 'all_spin_test') {
            return $this->viewPageAllSpinTest($request,$currentItem);
        }
        return view('pages.'.$currentItem->layout_show, compact('currentItem'));
    }
    private function viewPageAllDreamNumberDecoding($request,$currentItem){
        $tuKhoa = $request->tukhoa ?? null;
        $listMostView = DreamNumberDecoding::where('id','!=',$currentItem->id)
                                            ->orderBy('count','desc')
                                            ->orderBy('id','desc')
                                            ->limit(10)
                                            ->get();
        $listItems = DreamNumberDecoding::when($tuKhoa,function($q) use ($tuKhoa) {
                                            $q->where(function($q) use ($tuKhoa){
                                                $q->where('name','like',$tuKhoa);
                                                $q->orWhere('key_name','like','%'.$tuKhoa.'%');
                                            });
                                        })
                                        ->act()
                                        ->orderBy('id','desc')
                                        ->paginate(20);
        return view('pages.'.$currentItem->layout_show, compact('currentItem','listItems','listMostView'));
    }
    public function viewPageAllRredictTheOutCome($request,$currentItem)
    {
        $listPredictLotteryResultCategory = Cache::rememberForever('allPredictLotteryResultCategory', function () {
            return PredictLotteryResultCategory::orderBy('id','desc')->get();
        });
        $totalCate = count($listPredictLotteryResultCategory);
        $arrDb = [];
        foreach ($listPredictLotteryResultCategory as $key => $itemPredictLotteryResultCategory) {
            if ($key == 0) {
                $arrDb[$key] = DB::table("predict_lottery_results")->select("name","slug","img","seo_des",DB::raw('ROW_NUMBER() OVER(ORDER BY id desc) AS RowNo'))->where('predict_lottery_result_category_id',$itemPredictLotteryResultCategory->id)->where('act',1);
            }else {
                $arrDb[$key] = DB::table("predict_lottery_results")->select("name","slug","img","seo_des",DB::raw('ROW_NUMBER() OVER(ORDER BY id desc) AS RowNo'))->where('predict_lottery_result_category_id',$itemPredictLotteryResultCategory->id)->where('act',1)->unionall($arrDb[$key - 1]);
            }
        }
        $listItems = $arrDb[$totalCate-1]->orderBy('RowNo')->paginate(10);
        return view('pages.'.$currentItem->layout_show, compact('currentItem','listItems'));
    }
    public function viewPageAllSpinTest($request,$currentItem)
    {
        $listItemTestSpinCategory = TestSpinCategory::act()->get();
        $activeCate = TestSpinCategory::find(1);
        $listActiveTestSpinToday = $activeCate->testSpin()
                                                ->whereRaw('FIND_IN_SET(?, day_of_week)', [now()->dayOfWeek])
                                                ->get();
        $listItems = $activeCate->testSpin()
                                ->act()
                                ->get();
        $dataTestSpin = TestSpin::buildDataSpinCate($activeCate,$listActiveTestSpinToday);
        return view('pages.'.$currentItem->layout_show, compact('currentItem','listItemTestSpinCategory','listActiveTestSpinToday','listItems','dataTestSpin','activeCate'));
    }
}