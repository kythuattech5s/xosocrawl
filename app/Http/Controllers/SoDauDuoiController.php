<?php
namespace App\Http\Controllers;

use App\Models\SoDauDuoi;
use Lotto\Models\LottoRecord;

class SoDauDuoiController extends Controller
{	
    public function view($request, $route, $link){
        $currentItem = SoDauDuoi::slug($link)->act()->first();
        if ($currentItem == null) { abort(404); }
        $currentItem->updateCountView();
        if ($currentItem->lotto_category_id == 1) {
            $listItems = LottoRecord::select('id','fullcode','lotto_category_id','created_at')
                                    ->where('lotto_category_id',$currentItem->lotto_category_id)
                                    ->with(['lottoResultDetails'=>function($q){
                                        $q->whereIn('no_prize',[0,7]);
                                    }])
                                    ->whereHas('lottoResultDetails',function($q){
                                        $q->whereIn('no_prize',[0,7])->where('number','!=','');
                                    })
                                    ->orderBy('created_at','desc')
                                    ->paginate(30);
            return view('sodauduois.view',compact('currentItem','listItems'));
        }else{
            $listItems = LottoRecord::select('id','fullcode','lotto_category_id','created_at')
                                    ->where('lotto_category_id',$currentItem->lotto_category_id)
                                    ->whereHas('lottoResultDetails',function($q){
                                        $q->whereIn('no_prize',[0,8])->where('number','!=','');
                                    })
                                    ->groupBy('fullcode')
                                    ->orderBy('created_at','desc')
                                    ->paginate(30);
            $arrFullCode = $listItems->pluck('fullcode');
            $realItem = LottoRecord::select('id','fullcode','lotto_category_id','created_at','lotto_item_id')
                                    ->whereIn('fullcode',$arrFullCode)
                                    ->where('lotto_category_id',$currentItem->lotto_category_id)
                                    ->whereHas('lottoResultDetails',function($q){
                                        $q->whereIn('no_prize',[0,8])->where('number','!=','');
                                    })
                                    ->with(['lottoResultDetails'=>function($q){
                                        $q->whereIn('no_prize',[0,8])->where('number','!=','');
                                    }])
                                    ->whereHas('lottoItem')
                                    ->with('lottoItem')
                                    ->get();
            $arrData = [];
            foreach ($arrFullCode as $code) {
                $arrData[$code] = $realItem->where('fullcode',$code)->sortByDesc('lotto_item_id');
            }
            $numberTd = $currentItem->lotto_category_id == 3 ? 4:3;
            return view('sodauduois.view',compact('currentItem','listItems','arrData','numberTd'));
        }
    }
}