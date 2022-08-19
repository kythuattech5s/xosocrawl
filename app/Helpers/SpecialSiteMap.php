<?php
namespace App\Helpers;

use Lotto\Models\LottoCategory;
use Lotto\Models\LottoItem;
use Lotto\Models\LottoRecord;

class SpecialSiteMap
{
    
    public static function buildListSpecialSitemapLink(){
        $ret = [];
        $listLottoCategory = LottoCategory::whereIn('id',[1,3,4])->get();
        foreach ($listLottoCategory as $lottoCategory) {
            $oldestLottrecord = LottoRecord::where('lotto_category_id',$lottoCategory->id)->orderBy('created_at','asc')->first();
            // $yearAnchor = isset($oldestLottrecord) ? $oldestLottrecord->created_at->year
            // array_push($ret,$lottoCategory->site_map_id);
        }
        $listLottoItem = LottoItem::select('name','lotto_category_id')->whereIn('lotto_category_id',[1,3,4])->get();
        foreach ($listLottoItem as $lottoItem) {
            $strName = 'tinh-thanh/'.\Str::slug($lottoItem->name);
            array_push($ret,$strName);
        }
        return $ret;
    }
    public static function buildListSpecialSitemap(){
        $arrThu = ['thu-2','thu-3','thu-4','thu-5','thu-6','thu-7','chu-nhat'];
        $listLottoCategory = LottoCategory::whereIn('id',[1,3,4])->get();
        foreach ($listLottoCategory as $lottoCategory) {
            $listItems = [];
            if ($lottoCategory->id == 1) {
                $listItems = ['xo-so-truc-tiep/xsmb-mien-bac'];
            }
            if ($lottoCategory->id == 3) {
                $listItems = ['xo-so-truc-tiep/xsmn-mien-nam'];
            }
            if ($lottoCategory->id == 4) {
                $listItems = ['xo-so-truc-tiep/xsmt-mien-trung'];
            }
            foreach ($arrThu as $itemThu) {
                array_push($listItems,vsprintf($lottoCategory->slug_with_dayofweek,[$itemThu]));
            }
            $listLottoRecord = LottoRecord::select('lotto_category_id','fullcode','created_at')
                                            ->where('lotto_category_id',$lottoCategory->id)
                                            ->groupBy('fullcode')
                                            ->orderBy('created_at','desc')
                                            ->get();
            foreach ($listLottoRecord as $lottoRecord) {
                $dateString = Support::createShortCodeDay($lottoRecord->created_at);
                array_push($listItems,vsprintf($lottoCategory->slug_with_date,[$dateString]));
            }
            $path = public_path('sitemap/'.$lottoCategory->site_map_id);
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $html = \View::make('vh::more.template_sitemap_item_special', compact("listItems"))->render();
            file_put_contents($path.".xml", $html);
        }
        unset($listItems);
        $listLottoItem = LottoItem::select('id','name','lotto_category_id','prefix_sub_link','slug_date')->whereIn('lotto_category_id',[1,3,4])->get();
        foreach ($listLottoItem as $lottoItem) {
            $listItems = [];
            $listLottoRecord = $lottoItem->lottoRecords()
                                        ->select('lotto_item_id','fullcode','created_at')
                                        ->groupBy('fullcode')
                                        ->orderBy('created_at','desc')
                                        ->get();

            foreach ($listLottoRecord as $lottoRecord) {
                $dateString = Support::createShortCodeDay($lottoRecord->created_at);
                array_push($listItems,$lottoItem->prefix_sub_link.'/'.vsprintf($lottoItem->slug_date,[$dateString,$dateString]));
            }
            $strName = 'tinh-thanh/'.\Str::slug($lottoItem->name);
            $path = public_path('sitemap/'.$strName);
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $html = \View::make('vh::more.template_sitemap_item_special', compact("listItems"))->render();
            file_put_contents($path.".xml", $html);
        }
    }
}