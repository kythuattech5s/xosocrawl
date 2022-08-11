<?php

namespace Lotto\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lotto\Dtos\LottoItemMnCollection;
use Lotto\Enums\DayOfWeek;
use Lotto\Enums\LottoTypeRelate;
use Lotto\Helpers\LottoHelper;
use Lotto\Helpers\SeoHelper;
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
        $this->checkAbort404($lottoItem);
        $fullCode = $date->format('Ymd');
        $lottoRecord = $lottoItem->lottoRecords()->where('fullcode', $fullCode)->orderBy('created_at', 'desc')->limit(1)->first();
        $this->checkAbort404($lottoRecord);
        $linkPrefix = $request->segment(1, '');
        $currentItem = SeoHelper::getSeoProvince($lottoItem, $lottoRecord);


        return view('xoso.detail', compact('lottoItem', 'lottoRecord', 'linkPrefix', 'currentItem'));
    }
    public function xoSoMienBacToday(Request $request, $route, $link)
    {
        $linkPrefix = 'mien-bac';
        $lottoItem = LottoItem::find($route->map_id);
        $lottoRecord = $lottoItem->lottoRecords()->orderBy('created_at', 'desc')->limit(1)->first();
        $this->checkAbort404($lottoRecord);
        $currentItem = SeoHelper::getSeoProvince($lottoItem, $lottoRecord);
        $typeRelated = LottoTypeRelate::PROVINCE_TODAY;
        return view('xoso.detail', compact('lottoItem', 'lottoRecord', 'linkPrefix', 'currentItem', 'typeRelated'));
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
        $date = $lottoTime->getDateFromString($dateParam);
        $this->checkAbort404($lottoItem);
        $fullCode = $date->format('Ymd');
        $lottoRecord = $lottoItem->lottoRecords()->where('fullcode', $fullCode)->orderBy('created_at', 'desc')->limit(1)->first();
        $this->checkAbort404($lottoRecord);
        $linkPrefix = $request->segment(1, '');
        $currentItem = SeoHelper::getSeoProvince($lottoItem, $lottoRecord);
        $prefixPath = 'mien_nam';
        $typeRelated = LottoTypeRelate::PROVINCE_BY_DATE;
        return view('xoso.detail', compact('lottoItem', 'lottoRecord', 'linkPrefix', 'currentItem', 'prefixPath', 'typeRelated'));
    }
    protected function xoSoMienNamToday(Request $request, $lottoItem)
    {
        $this->checkAbort404($lottoItem);
        $lottoRecord = $lottoItem->lottoRecords()->orderBy('created_at', 'desc')->limit(1)->first();
        $this->checkAbort404($lottoRecord);
        $linkPrefix = $request->segment(1, '');
        $prefixPath = 'mien_nam';
        $typeRelated = LottoTypeRelate::PROVINCE_TODAY;
        $currentItem = SeoHelper::getSeoProvince($lottoItem, $lottoRecord);

        return view('xoso.detail', compact('lottoItem', 'lottoRecord', 'linkPrefix', 'prefixPath', 'typeRelated', 'currentItem'));
    }
    public function xoSoMienNamCategory(Request $request, $route, $link)
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
        $currentItem = SeoHelper::getSeoMienBacCategory($lottoCategory, $lottoItem, $lottoRecord);
        $linkFormat = [
            'slug' => $lottoCategory->slug_with_date,
            'format' => 'j-n-Y'
        ];
        $lottoItemMnCollection = new LottoItemMnCollection($lottoItems);
        $typeRelated = LottoTypeRelate::CATEGORY;
        return view('xoso.mien_nam', compact('lottoCategory', 'lottoItemMnCollection', 'lottoRecord', 'lottoItem',  'linkFormat', 'currentItem', 'typeRelated'));
    }
}
