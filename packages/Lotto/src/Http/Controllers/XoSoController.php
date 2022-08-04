<?php

namespace Lotto\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lotto\Models\LottoCategory;
use Lotto\Models\LottoItem;
use Lotto\Models\LottoRecord;
use Support;

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
        $lottoItem = LottoItem::where('slug_date', $url)->where("is_master", 0)->first();
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
        $currentItem = $this->retreiveObjectSeo($lottoRecord, $lottoItem);


        return view('xoso.detail', compact('lottoItem', 'lottoRecord', 'linkPrefix', 'currentItem'));
    }
    public function xoSoMienBacToday(Request $request, $route, $link)
    {
        $linkPrefix = 'mien-bac';
        $lottoItem = LottoItem::find($route->map_id);
        $lottoRecord = $lottoItem->lottoRecords()->orderBy('id', 'desc')->limit(1)->first();
        if (!$lottoRecord) {
            abort(404);
        }
        $currentItem = $this->retreiveObjectSeo($lottoRecord, $lottoItem);
        return view('xoso.detail', compact('lottoItem', 'lottoRecord', 'linkPrefix', 'currentItem'));
    }
    public function xoSoMienBacCategory(Request $request, $route, $link)
    {
        $linkPrefix = 'mien-bac';
        $lottoCategory = LottoCategory::find($route->map_id);
        if (!$lottoCategory) {
            abort(404);
        }
        $lottoItem = $lottoCategory->lottoNearestItem()->first();
        if (!$lottoItem) {
            abort(404);
        }
        $lottoRecord = $lottoItem->lottoRecords()->orderBy('id', 'desc')->limit(1)->first();
        if (!$lottoRecord) {
            abort(404);
        }
        $currentItem = $this->retreiveObjectSeo($lottoRecord, $lottoItem);
        return view('xoso.mien_bac', compact('lottoCategory', 'lottoItem', 'lottoRecord', 'linkPrefix', 'currentItem'));
    }
    protected function retreiveObjectSeo($lottoRecord, $lottoItem)
    {
        $currentItem = new \stdClass;
        $dateFormat = Support::format($lottoRecord->created_at);
        $params = [$lottoItem->short_name, $dateFormat, $lottoItem->name, Support::format($lottoRecord->created_at, 'd/m')];
        $currentItem->seo_title = $currentItem->name = vsprintf('%1$s %2$s - Xổ Số %3$s ngày %2$s - %1$s %4$s', $params);
        $currentItem->seo_des = vsprintf('%1$s %2$s - Kết quả xổ số %3$s ngày %2$s trực tiếp từ trường quay.✅ %1$s %4$s, KQ%1$s ngày %2$s nhanh top 1 #1 VN', $params);
        $currentItem->seo_key = vsprintf('%1$s %2$s, Xổ số %3$s ngày %5$s tháng %6$s năm %7$s, KQ%1$s ngày %2$s, %1$s %4$s', array_merge($params, [$lottoRecord->created_at->day, $lottoRecord->created_at->month, $lottoRecord->created_at->year]));
        return $currentItem;
    }
}
