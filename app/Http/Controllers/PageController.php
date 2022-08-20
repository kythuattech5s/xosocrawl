<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\DienToan123;
use App\Models\DienToan636;
use App\Models\DienToanThanTai;
use App\Models\DreamNumberDecoding;
use App\Models\KenoVietlott;
use App\Models\Max3dProVietlott;
use App\Models\Max3dVietlott;
use App\Models\Max4dVietlott;
use App\Models\Mega645VietlottNow;
use App\Models\News;
use App\Models\Page;
use App\Models\Power655VietlottNow;
use App\Models\PredictLotteryResultCategory;
use App\Models\StaticalCrawl;
use App\Models\TestSpin;
use App\Models\TestSpinCategory;
use DB;
use Cache;
use Lotto\Models\LottoCategory;

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
        if ($currentItem->layout_show == 'spin_test_vietlott') {
            return $this->viewPageSpinTestVietlott($request,$currentItem);
        }
        if ($currentItem->layout_show == 'mega_6_45_vietlott_ngay_hom_nay') {
            return $this->mega6_45VietlottNgayHomNay($request,$currentItem);
        }
        if ($currentItem->layout_show == 'power_6_55_vietlott_ngay_hom_nay') {
            return $this->power6_55VietlottNgayHomNay($request,$currentItem);
        }
        if ($currentItem->layout_show == 'max_3d_hom_nay') {
            return $this->max3dHomNay($request,$currentItem);
        }
        if ($currentItem->layout_show == 'max_3d_pro_hom_nay') {
            return $this->max3dProHomNay($request,$currentItem);
        }
        if ($currentItem->layout_show == 'xo_so_dien_toan') {
            return $this->xoSoDienToan($request,$currentItem);
        }
        if ($currentItem->layout_show == 'dien_toan_123') {
            return $this->dienToan123($request,$currentItem);
        }
        if ($currentItem->layout_show == 'dien_toan_than_tai') {
            return $this->dienToanThanTai($request,$currentItem);
        }
        if ($currentItem->layout_show == 'dien_toan_636') {
            return $this->dienToan636($request,$currentItem);
        }
        if ($currentItem->layout_show == 'all_tin_tuc') {
            return $this->allNews($request,$currentItem);
        }
        if ($currentItem->layout_show == 'max_4d_vietlott') {
            return $this->max4d($request,$currentItem);
        }
        if ($currentItem->layout_show == 'max_4d_vietlott_thu_3' || $currentItem->layout_show == 'max_4d_vietlott_thu_5' || $currentItem->layout_show == 'max_4d_vietlott_thu_7') {
            return $this->baseMax4d($request,$currentItem);
        }
        if ($currentItem->layout_show == 'xo_so_truc_tiep') {
            return $this->xoSoTrucTiep($request,$currentItem);
        }
        if ($currentItem->layout_show == 'keno_vietlott') {
            return $this->kenoVietlott($request,$currentItem);
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
    public function viewPageSpinTestVietlott($request,$currentItem)
    {
        $listItemTestSpinCategory = TestSpinCategory::act()->get();
        return view('pages.'.$currentItem->layout_show, compact('currentItem','listItemTestSpinCategory'));
    }
    public function mega6_45VietlottNgayHomNay($request,$currentItem)
    {
        $listItems = Mega645VietlottNow::act()->orderBy('time','desc')->paginate(7);
        return view('pages.'.$currentItem->layout_show, compact('currentItem','listItems'));
    }
    public function power6_55VietlottNgayHomNay($request,$currentItem)
    {
        $listItems = Power655VietlottNow::act()->orderBy('time','desc')->paginate(7);
        return view('pages.'.$currentItem->layout_show, compact('currentItem','listItems'));
    }
    public function max3dHomNay($request,$currentItem)
    {
        $listItems = Max3dVietlott::act()->orderBy('time','desc')->paginate(7);
        return view('pages.'.$currentItem->layout_show, compact('currentItem','listItems'));
    }
    public function max3dProHomNay($request,$currentItem)
    {
        $listItems = Max3dProVietlott::act()->orderBy('time','desc')->paginate(7);
        return view('pages.'.$currentItem->layout_show, compact('currentItem','listItems'));
    }
    public function xoSoDienToan($request,$currentItem)
    {
        $activeTime = StaticalCrawl::_getTime('bac');
        $firstItem = DienToan123::act()->orderBy('time','desc')->first();
        $secondItem = DienToanThanTai::act()->orderBy('time','desc')->first();
        $lastItem = DienToan636::act()->orderBy('time','desc')->first();
        return view('pages.dien_toan.base', compact('currentItem','activeTime','firstItem','secondItem','lastItem'));
    }
    public function dienToan123($request,$currentItem)
    {
        $listItems = DienToan123::act()->orderBy('time','desc')->paginate(10);
        return view('pages.dien_toan.dien_toan_list_item_base', compact('currentItem','listItems'));
    }
    public function dienToanThanTai($request,$currentItem)
    {
        $listItems = DienToanThanTai::act()->orderBy('time','desc')->paginate(10);
        return view('pages.dien_toan.dien_toan_list_item_base', compact('currentItem','listItems'));
    }
    public function dienToan636($request,$currentItem)
    {
        $listItems = DienToan636::act()->orderBy('time','desc')->paginate(10);
        return view('pages.dien_toan.dien_toan_list_item_base', compact('currentItem','listItems'));
    }
    public function xoSoDienToanTheoNgay($id)
    {
        preg_match('/(\d{1,2})-(\d{1,2})-(\d{4})/', str_replace('/','-',$id), $dates);
        if (count($dates) == 4) {
            $day = $dates[1] < 10 ? $dates[1]:$dates[1];
            $month = $dates[2] < 10 ? $dates[2]:$dates[2];
            $year = $dates[3];
            $code = $year.$month.$day;
            $activeTime = now()->createFromFormat('d/m/Y H:i:s',$day.'/'.$month.'/'.$year.' 18:05:00');
            $firstItem = DienToan123::act()->where('fullcode',$code)->first();
            $secondItem = DienToanThanTai::act()->where('fullcode',$code)->first();
            $lastItem = DienToan636::act()->where('fullcode',$code)->first();
            return view('pages.dien_toan.all_dien_toan', compact('activeTime','firstItem','secondItem','lastItem'));
        }
        abort(404);
    }
    public function allNews($request,$currentItem)
    {
        $listItems = News::act()->orderBy('created_at','desc')->paginate(10);
        return view('pages.all_tin_tuc', compact('currentItem','listItems'));
    }
    public function baseMax4d($request,$currentItem)
    {
        $listItems = Max4dVietlott::act()->where('type',$currentItem->layout_show)->orderBy('time','desc')->paginate(10);
        return view('pages.base_max4d', compact('currentItem','listItems'));
    }
    public function max4d($request,$currentItem)
    {
        $listItems = Max4dVietlott::act()->orderBy('time','desc')->paginate(10);
        return view('pages.base_max4d', compact('currentItem','listItems'));
    }
    public function xoSoTrucTiep($request,$currentItem)
    {
        $lottoCategories = LottoCategory::whereIn('id',[1,3,4])->get();
        $arrData = [];
        foreach ($lottoCategories as $key => $lottoCategory) {
            $dataAdd = [];
            $dataAdd['lottoCategory'] = $lottoCategory;
            $listLottoItems = $lottoCategory->lottoNearestItem(4)->groupBy('dow');
            $lottoItems = $listLottoItems->first();
            foreach ($listLottoItems as $tmp) {
                if (count($tmp) > count($lottoItems)) {
                    $lottoItems = $tmp;
                }
            }
            $dataAdd['lottoItem'] = $lottoItem = $lottoItems->first();
            $dataAdd['lottoRecord'] =  $lottoRecord = $lottoItem->lottoRecords()->orderBy('created_at', 'desc')->first();
            $dataAdd['linkFormat'] = $linkFormat = [
                'slug' => $lottoCategory->slug_with_date,
                'format' => 'j-n-Y'
            ];
    
            $dataAdd['lottoItemMnCollection'] = $lottoItemMnCollection = $lottoRecord->toLottoItemMnCollection();
            array_push($arrData,$dataAdd);
        }
        return view('pages.'.$currentItem->layout_show, compact('currentItem','arrData'));
    }
    public function kenoVietlott($request,$currentItem)
    {
        $listItems = KenoVietlott::act()->orderBy('time','desc')->orderBy('time_spin','desc')->paginate(10);
        return view('pages.'.$currentItem->layout_show, compact('currentItem','listItems'));
    }
}