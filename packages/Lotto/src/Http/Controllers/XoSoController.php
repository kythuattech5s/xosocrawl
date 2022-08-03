<?php

namespace Lotto\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lotto\Models\LottoItem;
use Lotto\Models\LottoRecord;

class XoSoController extends Controller
{

    public function xoSoMienBac(Request $request)
    {

        $url =  $request->segment(2, '');
        if (strlen($url) == 0) {
            abort(404);
        }
        preg_match_all('/([1-9]|[1-2][0-9]|3[0-1])-(1[1-2]|[1-9])-\d{4}/mi', $url, $dateParams);
        $url = preg_replace('/([1-9]|[1-2][0-9]|3[0-1])-(1[1-2]|[1-9])-\d{4}/mi', '%s', $url);
        $dateParams = $dateParams[0];
        if (count($dateParams) != 2) {
            abort(404);
        }
        $dateParam = $dateParams[0];
        $lottoItem = LottoItem::where('slug_date', $url)->first();
        $lottoTime = $lottoItem->lottoTime;
        $date = $lottoTime->getDateFromString($dateParam);
        if (!$lottoItem) {
            abort(404);
        }
        $fullCode = $date->format('Ymd');
        $lottoRecord = $lottoItem->lottoRecords()->where('fullcode', $fullCode)->orderBy('id', 'desc')->limit(1)->first();
        if (!$lottoRecord) {
            abort(404);
        }
        $linkPrefix = $request->segment(1, '');

        return view('xoso.detail', compact('lottoItem', 'lottoRecord', 'linkPrefix'));
    }
    public function xoSoMienBacToday(Request $request, $route, $link)
    {
        $linkPrefix = 'mien-bac';
        $lottoItem = LottoItem::find($route->map_id);
        $lottoRecord = $lottoItem->lottoRecords()->orderBy('id', 'desc')->limit(1)->first();
        if (!$lottoRecord) {
            abort(404);
        }
        return view('xoso.detail', compact('lottoItem', 'lottoRecord', 'linkPrefix'));
    }
}
