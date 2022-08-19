<?php

namespace Lotto\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BannerGdn;
use App\Models\BannerGdnCategory;
use Illuminate\Http\Request;
use Lotto\Dtos\LottoItemMnCollection;
use Lotto\Dtos\NumResult;
use Lotto\Enums\DayOfWeek;
use Lotto\Enums\LottoTypeRelate;
use Lotto\Helpers\LottoHelper;
use Lotto\Helpers\SeoHelper;
use Lotto\Models\LottoCategory;
use Lotto\Models\LottoItem;
use Lotto\Models\LottoRecord;
use Lotto\Models\LottoResultDetail;
use Lotto\Models\LottoYesterday;
use Lotto\Models\StaticalByDay;
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
        $lottoCategory = LottoCategory::find(1);
        $dateParam = $dateParams[0];
        $lottoItem = LottoItem::where('slug_date', $url)->where("is_master", 0)->first();
        $lottoTime = $lottoItem->lottoTime;
        $date = $lottoTime->getDateFromString($dateParam);
        $this->checkAbort404($lottoItem);
        $fullCode = $date->format('Ymd');
        $lottoRecord = $lottoItem->lottoRecords()->where('fullcode', $fullCode)->orderBy('created_at', 'desc')->limit(1)->first();
        $this->checkAbort404($lottoRecord);
        $linkPrefix = $request->segment(1, '');
        $currentItem = SeoHelper::getSeoProvince($lottoItem, $lottoRecord);
        $typeRelated = LottoTypeRelate::PROVINCE_BY_DATE;

        return view('xoso.detail', compact('lottoCategory', 'lottoItem', 'lottoRecord', 'linkPrefix', 'currentItem', 'typeRelated'));
    }
    public function xoSoMienBacToday(Request $request, $route, $link)
    {
        $lottoCategory = LottoCategory::find(1);

        $lottoItem = LottoItem::find($route->map_id);
        $linkPrefix = $lottoItem->prefix_sub_link;
        $lottoRecord = $lottoItem->lottoRecords()->orderBy('created_at', 'desc')->limit(1)->first();
        $this->checkAbort404($lottoRecord);
        $currentItem = SeoHelper::getSeoProvince($lottoItem, $lottoRecord);
        $typeRelated = LottoTypeRelate::PROVINCE_TODAY;
        return view('xoso.detail', compact('lottoCategory', 'lottoItem', 'lottoRecord', 'linkPrefix', 'currentItem', 'typeRelated'));
    }
    public function xoSoMienBacCategory(Request $request, $route, $link)
    {

        $lottoCategory = LottoCategory::find($route->map_id);

        $this->checkAbort404($lottoCategory);
        $lottoItem = $lottoCategory->lottoNearestItem()->first();
        $this->checkAbort404($lottoItem);
        $lottoRecord = $lottoItem->lottoRecords()->orderBy('created_at', 'desc')->limit(1)->first();
        $this->checkAbort404($lottoRecord);
        $currentItem = SeoHelper::getSeoMienBacCategory($lottoCategory, $lottoItem, $lottoRecord);
        $linkFormat = [
            'slug' => $lottoCategory->slug_with_date,
            'format' => 'j-n-Y'
        ];
        $typeRelated = LottoTypeRelate::CATEGORY;
        return view('xoso.mien_bac', compact('lottoCategory', 'lottoItem', 'lottoRecord', 'linkFormat', 'currentItem', 'typeRelated'));
    }
    public function xoSoMienBacCategoryDow(Request $request, $id1, $id2)
    {
        if ($id1 !== $id2) {
            abort(404);
        }
        $dow = DayOfWeek::fromString($id1);
        $lottoCategory = LottoCategory::find(1);

        $lottoItem = $lottoCategory->lottoTodayItems($dow)->first();
        $this->checkAbort404($lottoItem);
        $lottoRecord = $lottoItem->lottoRecords()->whereHas('lottoTimes', function ($q) use ($dow) {
            $q->where('lotto_times.dayofweek', $dow);
        })->orderBy('created_at', 'desc')->limit(1)->first();
        $this->checkAbort404($lottoRecord);
        $typeRelated = LottoTypeRelate::DOW;
        $currentItem = SeoHelper::getSeoMienBacDow($lottoCategory, $lottoItem, $lottoRecord);
        return view('xoso.mien_bac', compact('lottoCategory', 'lottoItem', 'lottoRecord',  'currentItem', 'typeRelated'));
    }
    public function xoSoMienBacCategoryDmy(Request $request, $id1, $id2)
    {
        if ($id1 !== $id2) {
            abort(404);
        }
        $lottoCategory = LottoCategory::find(1);
        $date = Support::isDateTime($id1, 'j-n-Y');
        if (!$date) {
            abort(404);
        }
        $fullCode = $date->format('Ymd');
        $lottoItem = $lottoCategory->lottoItems()->select('lotto_items.*')->whereHas('lottoRecords', function ($q) use ($fullCode) {
            $q->where('fullcode', $fullCode);
        })->first();
        $this->checkAbort404($lottoItem);
        $lottoRecord = $lottoItem->lottoRecords()->where('fullcode', $fullCode)->orderBy('created_at', 'desc')->limit(1)->first();
        $this->checkAbort404($lottoRecord);
        $currentItem = SeoHelper::getSeoMienBacDmY($lottoCategory, $lottoItem, $lottoRecord);
        $linkFormat = [
            'slug' => $lottoCategory->slug_with_date,
            'format' => 'j-n-Y'
        ];
        $typeRelated = LottoTypeRelate::DMY;

        return view('xoso.mien_bac', compact('lottoCategory', 'lottoItem', 'lottoRecord', 'linkFormat', 'currentItem', 'typeRelated'));
    }

    private function checkAbort404($obj)
    {
        if (!$obj) {
            abort(404);
        }
    }
    public function xoSoMienBacMore(Request $request, $route, $link)
    {
        if (!$request->ajax()) abort(404);
        $lottoRecordId = (int)$request->input('lotto_recrod_id', 0);
        $lottoType = $request->input('lotto_type', '');

        $lottoRecord = LottoRecord::find($lottoRecordId);
        $this->checkAbort404($lottoRecord);
        $lottoItem = $lottoRecord->lottoItem;
        $this->checkAbort404($lottoItem);
        $lottoCategory = $lottoItem->lottoCategory();
        $this->checkAbort404($lottoCategory);

        $q = LottoRecord::where('lotto_category_id', $lottoRecord->lotto_category_id)->orderBy('created_at', 'desc');

        $lottoTypeRelate = LottoTypeRelate::getByValue($lottoType, LottoTypeRelate::CATEGORY);
        $lottoTypeRelate->addCondition($q, $lottoRecord, $lottoItem);

        $relateRecords = $q->simplePaginate(4)->appends($request->except(['page', '_token']));;

        return view('xoso.mien_bac.related.ajax_more', compact('lottoItem', 'lottoRecord', 'relateRecords'));
    }

    public function xoSoMienNam(Request $request)
    {
        return $this->xoSomienX($request);
    }
    public function xoSoMienTrung(Request $request)
    {
        return $this->xoSomienX($request);
    }
    public function xoSoMienX(Request $request)
    {

        $url =  $request->segment(2, '');
        if (strlen($url) == 0) {
            abort(404);
        }
        $lottoItem = LottoItem::where('slug', $url)->where("is_master", 0)->first();
        if ($lottoItem) {
            return $this->xoSoMienNamToday($request, $lottoItem);
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
        $lottoCategory = $lottoItem->lottoCategory;
        $date = $lottoTime->getDateFromString($dateParam);
        $this->checkAbort404($lottoItem);
        $fullCode = $date->format('Ymd');
        $lottoRecord = $lottoItem->lottoRecords()->where('fullcode', $fullCode)->orderBy('created_at', 'desc')->limit(1)->first();
        $this->checkAbort404($lottoRecord);
        $linkPrefix = $request->segment(1, '');
        $currentItem = SeoHelper::getSeoProvince($lottoItem, $lottoRecord);
        $prefixPath = 'mien_nam';
        $typeRelated = LottoTypeRelate::PROVINCE_BY_DATE;
        return view('xoso.detail', compact('lottoCategory', 'lottoItem', 'lottoRecord', 'linkPrefix', 'currentItem', 'prefixPath', 'typeRelated'));
    }
    protected function xoSoMienNamToday(Request $request, $lottoItem)
    {
        $this->checkAbort404($lottoItem);
        $lottoCategory = $lottoItem->lottoCategory;
        $lottoRecord = $lottoItem->lottoRecords()->orderBy('created_at', 'desc')->limit(1)->first();
        $this->checkAbort404($lottoRecord);
        $linkPrefix = $request->segment(1, '');
        $prefixPath = 'mien_nam';
        $typeRelated = LottoTypeRelate::PROVINCE_TODAY;
        $currentItem = SeoHelper::getSeoProvince($lottoItem, $lottoRecord);

        return view('xoso.detail', compact('lottoCategory', 'lottoItem', 'lottoRecord', 'linkPrefix', 'prefixPath', 'typeRelated', 'currentItem'));
    }
    public function xoSoMienXCategory(Request $request, $route, $link)
    {

        $lottoCategory = LottoCategory::find($route->map_id);

        $this->checkAbort404($lottoCategory);
        $listLottoItems = $lottoCategory->lottoNearestItem(4)->groupBy('dow');
        $lottoItems = $listLottoItems->first();
        foreach ($listLottoItems as $tmp) {
            if (count($tmp) > count($lottoItems)) {
                $lottoItems = $tmp;
            }
        }
        $lottoItem = $lottoItems->first();
        $lottoRecord = $lottoItem->lottoRecords()->orderBy('created_at', 'desc')->first();
        $this->checkAbort404($lottoRecord);
        $currentItem = SeoHelper::getSeoMienXCategory($lottoCategory);
        $linkFormat = [
            'slug' => $lottoCategory->slug_with_date,
            'format' => 'j-n-Y'
        ];

        $lottoItemMnCollection = $lottoRecord->toLottoItemMnCollection();
        $typeRelated = LottoTypeRelate::CATEGORY;
        return view('xoso.mien_nam', compact('lottoCategory', 'lottoItemMnCollection', 'lottoRecord', 'lottoItem',  'linkFormat', 'currentItem', 'typeRelated'));
    }
    public function xoSoMienNamMore(Request $request, $route, $link)
    {
        if (!$request->ajax()) abort(404);
        $lottoRecordId = (int)$request->input('lotto_recrod_id', 0);
        $typeRelated = $request->input('lotto_type', '');

        $lottoRecord = LottoRecord::find($lottoRecordId);
        $this->checkAbort404($lottoRecord);
        $lottoItem = $lottoRecord->lottoItem;
        $this->checkAbort404($lottoItem);
        $lottoCategory = $lottoItem->lottoCategory;
        $this->checkAbort404($lottoCategory);

        $createdAt = $lottoRecord->created_at;
        $createdAt->hour = 0;
        $createdAt->minute = 0;
        $createdAt->second = 0;

        $q = LottoRecord::where('created_at', '<', $createdAt)->where('lotto_category_id', $lottoRecord->lotto_category_id)->groupBy('fullcode')->orderBy('created_at', 'desc');
        $lottoTypeRelate = LottoTypeRelate::getByValue($typeRelated, LottoTypeRelate::CATEGORY);
        $lottoTypeRelate->addCondition($q, $lottoRecord, $lottoItem);
        $relateRecords = $q->simplePaginate(4)->appends($request->except(['page', '_token']));;

        return view('xoso.mien_nam.related.ajax_more', compact('lottoItem', 'lottoRecord', 'relateRecords', 'typeRelated', 'lottoCategory'));
    }

    protected function xoSoMienNamCategoryDow(Request $request, $id1, $id2)
    {
        return $this->xoSoMienXCategoryDow($request, $id1, $id2, 3);
    }
    protected function xoSoMienTrungCategoryDow(Request $request, $id1, $id2)
    {
        return $this->xoSoMienXCategoryDow($request, $id1, $id2, 4);
    }
    public function xoSoMienXCategoryDow(Request $request, $id1, $id2, $lottoCategoryId)
    {
        if ($id1 !== $id2) {
            abort(404);
        }
        $dow = DayOfWeek::fromString($id1);
        $lottoCategory = LottoCategory::find($lottoCategoryId);

        $lottoItem = $lottoCategory->lottoTodayItems($dow)->first();
        $this->checkAbort404($lottoItem);
        $lottoRecord = $lottoItem->lottoRecords()->whereHas('lottoTimes', function ($q) use ($dow) {
            $q->where('lotto_times.dayofweek', $dow);
        })->orderBy('created_at', 'desc')->limit(1)->first();
        $this->checkAbort404($lottoRecord);
        $typeRelated = LottoTypeRelate::DOW;
        $lottoItemMnCollection = $lottoRecord->toLottoItemMnCollection();
        $typeRelated = LottoTypeRelate::DOW;
        $currentItem = SeoHelper::getSeoMienXDow($lottoCategory, $lottoItemMnCollection);
        return view('xoso.mien_nam', compact('lottoItemMnCollection', 'lottoCategory', 'lottoItem', 'lottoRecord',  'currentItem', 'typeRelated'));
    }
    public function xoSoMienNamCategoryDmy(Request $request, $id1, $id2)
    {
        return $this->xoSoMienXCategoryDmy($request, $id1, $id2, 3);
    }
    public function xoSoMienTrungCategoryDmy(Request $request, $id1, $id2)
    {
        return $this->xoSoMienXCategoryDmy($request, $id1, $id2, 4);
    }
    public function xoSoMienXCategoryDmy(Request $request, $id1, $id2, $lottoCategoryId)
    {
        if ($id1 !== $id2) {
            abort(404);
        }
        $lottoCategory = LottoCategory::find($lottoCategoryId);
        $date = Support::isDateTime($id1, 'j-n-Y');
        if (!$date) {
            abort(404);
        }
        $fullCode = $date->format('Ymd');
        $lottoItem = $lottoCategory->lottoItems()->select('lotto_items.*')->whereHas('lottoRecords', function ($q) use ($fullCode) {
            $q->where('fullcode', $fullCode);
        })->first();
        $this->checkAbort404($lottoItem);
        $lottoRecord = $lottoItem->lottoRecords()->where('fullcode', $fullCode)->orderBy('created_at', 'desc')->limit(1)->first();
        $this->checkAbort404($lottoRecord);
        $currentItem = SeoHelper::getSeoMienXDmY($lottoCategory, $lottoItem, $lottoRecord);
        $linkFormat = [
            'slug' => $lottoCategory->slug_with_date,
            'format' => 'j-n-Y'
        ];
        $lottoItemMnCollection = $lottoRecord->toLottoItemMnCollection();
        $typeRelated = LottoTypeRelate::DMY;

        return view('xoso.mien_nam', compact('lottoItemMnCollection', 'lottoCategory', 'lottoItem', 'lottoRecord', 'linkFormat', 'currentItem', 'typeRelated'));
    }
    public function getLinkLottoTarget(Request $request, $route, $link)
    {

        try {
            $date = $request->input('date', '');
            $type = $request->input('type', 0);
            $category = (int)$request->input('category', 0);
            $item = (int)$request->input('item', 0);

            $date = \Carbon\Carbon::createFromFormat('Y-m-d', $date);
            $lottoCategory = LottoCategory::find($category);
            $lottoItem = LottoItem::find($item);
            $this->checkAbort404($lottoCategory);
            $lottoType = LottoTypeRelate::getByValue($type, LottoTypeRelate::CATEGORY);
            $link = $lottoType->retreiveLinkTarget($date, $lottoCategory, $lottoItem);
            return response()->json(['code' => 200, 'link' => $link]);
        } catch (\Throwable $th) {
            abort(404);
        }
    }
    public function lottoYesterday(Request $request, $route, $link)
    {
        $currentItem = LottoYesterday::find($route->map_id);
        $typeRelated = LottoTypeRelate::DOW;
        $now = now();
        $now->hour = 0;
        $now->minute = 0;
        $now->second = 0;
        $lottoCategory = $currentItem->lottoCategory;
        $lottoRecord = LottoRecord::where('lotto_category_id', $lottoCategory->id)->where('created_at', '<', $now)->orderBy('created_at', 'desc')->limit(1)->first();
        $lottoItem = $lottoRecord->lottoItem;

        $lottoItemMnCollection = collect();
        if ($lottoCategory->id > 1) {
            $lottoItemMnCollection = $lottoRecord->toLottoItemMnCollection();
            // dd($lottoItemMnCollection);
        }
        $viewPath = $lottoCategory->id == 1 ? 'mien_bac' : 'mien_nam';
        return view('xoso.yesterday', compact('currentItem', 'typeRelated', 'lottoCategory', 'lottoItem', 'lottoRecord', 'lottoItemMnCollection', 'viewPath'));
    }
    public function staticalByDay(Request $request, $route, $link)
    {

        $currentItem = StaticalByDay::find($route->map_id);
        if (!$currentItem) abort(404);
        if ($request->isMethod('post')) {
            $numOfDay = (int)$request->input('numOfDay', 0);
            $item = StaticalByDay::where('lotto_category_id', $currentItem->lotto_category_id)->where('num_day', $numOfDay)->first();

            if ($item) {
                return \redirect($item->slug);
            } else {
                abort(404);
            }
        }
        $numOfDay = $currentItem->num_day;
        $lottoCategory =  $currentItem->lottoCategory;

        $records = $lottoCategory->lottoRecords()->select('created_at', 'id')->orderBy('created_at', 'desc')->limit($numOfDay + 1)->get();
        $createdAt = $records[count($records) - 1]->created_at;

        $numResult = new NumResult($lottoCategory, $createdAt, $numOfDay);
        $numResult->analytic();


        $staticals = $lottoCategory->lottoRecords()->where('created_at', '>', $createdAt)->orderBy('created_at', 'desc')->paginate(10);
        $staticalItems = StaticalByDay::where('lotto_category_id', $lottoCategory->id)->get();

        return view('xoso.statical.by_day', compact('currentItem', 'staticals', 'lottoCategory', 'staticalItems', 'numOfDay', 'numResult'));
    }
    public function staticalByDayMienX(Request $request, $route, $link)
    {

        $currentItem = StaticalByDay::find($route->map_id);
        if (!$currentItem) abort(404);
        if ($request->isMethod('post')) {
            $type = (int)$request->input('type', 0);
            $provinceId = (int)$request->input('provinceId', 0);
            $item = StaticalByDay::find($provinceId);
            $request->session()->put('num_result_type', $type);
            if ($item) {
                return \redirect($item->slug);
            } else {
                abort(404);
            }
        }
        $lottoCategory =  $currentItem->lottoCategory;
        $statical_by_day_id = $currentItem->statical_by_day_id;
        if ($statical_by_day_id == 0) {
            $tmpRecords = LottoRecord::select('id')->groupBy('fullcode')->where('lotto_category_id', $currentItem->lotto_category_id)->orderBy('created_at', 'desc')->limit(30)->get();
            $strIds = $tmpRecords->implode('id', ',');
            $staticals = LottoRecord::whereIn('id', explode(',', $strIds))->orderBy('created_at', 'desc')->paginate(10);
            $provinces = StaticalByDay::where('statical_by_day_id', $currentItem->id)->orderBy('name')->get();
            return view('xoso.statical.by_day_mienx', compact('currentItem',  'lottoCategory', 'staticals', 'provinces'));
        } else {
            $numResultType = $request->session()->get('num_result_type', 0);
            $numResultType = in_array($numResultType, [0, 2, 3]) ? $numResultType : 0;
            $numOfDay = 30;
            $records = $lottoCategory->lottoRecords()->select('created_at', 'id')->where('lotto_item_id', $currentItem->lotto_item_id)->orderBy('created_at', 'desc')->limit($numOfDay + 1)->get();
            $createdAt = $records[count($records) - 1]->created_at;

            $staticals = $lottoCategory->lottoRecords()->where('created_at', '>', $createdAt)->where('lotto_item_id', $currentItem->lotto_item_id)->orderBy('created_at', 'desc')->paginate(10);
            $staticalItems = StaticalByDay::where('lotto_category_id', $lottoCategory->id)->get();
            return view('xoso.statical.by_day_detail_mienx', compact('currentItem', 'staticals', 'lottoCategory', 'staticalItems', 'numOfDay', 'numResultType'));
        }
    }
    
}
