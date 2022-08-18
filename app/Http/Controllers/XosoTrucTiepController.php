<?php
namespace App\Http\Controllers;

use App\Models\XosoTrucTiepItem;
use Lotto\Enums\LottoTypeRelate;

class XosoTrucTiepController extends Controller
{	
    public function view($prefix){
        $currentItem = XosoTrucTiepItem::where('prefix_link',$prefix)->act()->first();
        if ($currentItem == null) {
            return redirect('xo-so-truc-tiep');
        }
        $currentItem->updateCountView();
        $lottoCategory = $currentItem->lottoCategory;
        $typeRelated = LottoTypeRelate::CATEGORY;
        $lottoItem = $lottoCategory->lottoNearestItem()->first();
        $lottoRecord = $lottoItem->lottoRecords()->orderBy('created_at', 'desc')->limit(1)->first();
        $lottoItemMnCollection = $lottoRecord->toLottoItemMnCollection();
        $linkFormat = [
            'slug' => $lottoCategory->slug_with_date,
            'format' => 'j-n-Y'
        ];
        return view('xoso.truc_tiep.view',compact('currentItem','lottoCategory','typeRelated','lottoItem','lottoRecord','linkFormat','lottoItemMnCollection'));
    }
}