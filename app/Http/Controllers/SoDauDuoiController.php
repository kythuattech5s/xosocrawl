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
            $listItems = LottoRecord::where('lotto_category_id',$currentItem->lotto_category_id)
                                    ->with(['lottoResultDetails'=>function($q){
                                        $q->whereIn('no_prize',[0,7]);
                                    }])
                                    ->groupBy('fullcode')
                                    ->orderBy('created_at','desc')
                                    ->paginate(20);
        }else{
            $listItems = [];
        }
        return view('sodauduois.view',compact('currentItem','listItems'));
    }
}