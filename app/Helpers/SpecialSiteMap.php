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
            array_push($ret,[
                'link' => $lottoCategory->site_map_id,
                'time' => now()
            ]);
            $oldestLottrecord = LottoRecord::where('lotto_category_id',$lottoCategory->id)->orderBy('created_at','asc')->first();
            $yearAnchor = isset($oldestLottrecord) ? $oldestLottrecord->created_at->year: now()->year;
            for ($i = now()->year; $i >= $yearAnchor; $i--) { 
                $itemAdd = [];
                $itemAdd['link'] = $lottoCategory->site_map_id.'/'.$i;
                $yearDiff = now()->year - $i;
                $itemAdd['time'] = $yearDiff > 0 ? now()->subYear( $yearDiff)->endOfYear():now();
                array_push($ret,$itemAdd);
            }
        }
        $listLottoItem = LottoItem::select('id','name','lotto_category_id')->whereIn('lotto_category_id',[1,3,4])->get();
        foreach ($listLottoItem as $lottoItem) {
            $oldestLottrecord = $lottoItem->lottoRecords()->orderBy('created_at','asc')->first();
            $strName = 'tinh-thanh/'.\Str::slug($lottoItem->name);
            $yearAnchor = isset($oldestLottrecord) ? $oldestLottrecord->created_at->year: now()->year;
            for ($i = now()->year; $i >= $yearAnchor; $i--) { 
                $itemAdd = [];
                $itemAdd['link'] = $strName.'/'.$i;
                $yearDiff = now()->year - $i;
                $itemAdd['time'] = $yearDiff > 0 ? now()->subYear( $yearDiff)->endOfYear():now();
                array_push($ret,$itemAdd);
            }
        }
        return $ret;
    }
    public static function buildListSpecialSitemap(){
        set_time_limit(-1);
        static::buildLottoCategoryXmlFile();
        static::buildLottoItemXmlFile();
        
    }
    public function createXmlFile($listItems,$path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $html = \View::make('vh::more.template_sitemap_item_special', compact('listItems'))->render();
        file_put_contents($path.".xml", $html);
    }
    public static function buildLottoCategoryXmlFile()
    {
        $listLottoCategory = LottoCategory::whereIn('id',[1,3,4])->get();
        foreach ($listLottoCategory as $lottoCategory) {

            static::buildLottoCategorySpecialXmlFile($lottoCategory);

            $oldestLottrecord = LottoRecord::where('lotto_category_id',$lottoCategory->id)->orderBy('created_at','asc')->first();
            $yearAnchor = isset($oldestLottrecord) ? $oldestLottrecord->created_at->year: now()->year;

            for ($i = now()->year; $i >= $yearAnchor; $i--) { 
                $listItems = [];
                $listLottoRecord = LottoRecord::select('lotto_category_id','fullcode','created_at')
                                                ->selectRaw('year(created_at) as year')
                                                ->where('lotto_category_id',$lottoCategory->id)
                                                ->having('year',$i)
                                                ->groupBy('fullcode')
                                                ->orderBy('created_at','desc')
                                                ->get();
                foreach ($listLottoRecord as $lottoRecord) {
                    $dateString = Support::createShortCodeDay($lottoRecord->created_at);
                    $itemAdd = [];
                    $itemAdd['slug'] = vsprintf($lottoCategory->slug_with_date,[$dateString]);
                    if (now()->diffInYears($lottoRecord->created_at) > 0) {
                        $itemAdd['changefreq'] = 'yearly';
                    }else{
                        if (now()->diffInMonths($lottoRecord->created_at) > 0) {
                            $itemAdd['changefreq'] = 'monthly';
                        }else{
                            if (now()->diff($lottoRecord->created_at)->days > 1) {
                                $itemAdd['changefreq'] = 'weekly';
                            }else{
                                $itemAdd['changefreq'] = 'daily';
                            }
                        }
                    }
                    $itemAdd['lastmod'] = $lottoRecord->created_at;
                    array_push($listItems,$itemAdd);
                }
                $path = public_path('sitemap/'.$lottoCategory->site_map_id.'/'.$i);
                static::createXmlFile($listItems,$path);
            }
        }
    }
    public static function buildLottoCategorySpecialXmlFile($lottoCategory)
    {
        $arrThu = ['thu-2','thu-3','thu-4','thu-5','thu-6','thu-7','chu-nhat'];
        if ($lottoCategory->id == 1) {
            $listItemFix = [
                [
                    'slug' => 'xo-so-truc-tiep/xsmb-mien-bac',
                    'lastmod' => now()->subDay(1),
                    'changefreq' => 'daily'
                ]
            ];
        }
        if ($lottoCategory->id == 3) {
            $listItemFix = [
                [
                    'slug' => 'xo-so-truc-tiep/xsmb-mien-nam',
                    'lastmod' => now()->subDay(1),
                    'changefreq' => 'daily'
                ]
            ];
        }
        if ($lottoCategory->id == 4) {
            $listItemFix = [
                [
                    'slug' => 'xo-so-truc-tiep/xsmb-mien-trung',
                    'lastmod' => now()->subDay(1),
                    'changefreq' => 'daily'
                ]
            ];
        }
        foreach ($arrThu as $keyThu => $itemThu) {
            $itemAdd = [];
            $itemAdd['slug'] = vsprintf($lottoCategory->slug_with_dayofweek,[$itemThu]);
            $itemAdd['changefreq'] = 'weekly';
            $currentDayOfWeek = now()->dayOfWeek == 0 ? 7:now()->dayOfWeek;
            if ($currentDayOfWeek > $keyThu) {
                $itemAdd['lastmod'] = now()->subDay($currentDayOfWeek - $keyThu);
            }else{
                $itemAdd['lastmod'] = now()->addDay($keyThu - $currentDayOfWeek)->subDay(7);
            }
            array_push($listItemFix,$itemAdd);
        }
        $path = public_path('sitemap/'.$lottoCategory->site_map_id);
        static::createXmlFile($listItemFix,$path);
    }
    public static function buildLottoItemXmlFile()
    {
        $listLottoItem = LottoItem::select('id','name','lotto_category_id','prefix_sub_link','slug_date')->whereIn('lotto_category_id',[1,3,4])->get();
        foreach ($listLottoItem as $lottoItem) {
            
            $oldestLottrecord = $lottoItem->lottoRecords()->orderBy('created_at','asc')->first();
            $yearAnchor = isset($oldestLottrecord) ? $oldestLottrecord->created_at->year: now()->year;
            for ($i = now()->year; $i >= $yearAnchor; $i--) { 
                $listItems = [];
                $listLottoRecord = $lottoItem->lottoRecords()
                                        ->select('lotto_item_id','fullcode','created_at')
                                        ->selectRaw('year(created_at) as year')
                                        ->groupBy('fullcode')
                                        ->having('year',$i)
                                        ->orderBy('created_at','desc')
                                        ->get();
                foreach ($listLottoRecord as $lottoRecord) {
                    $dateString = Support::createShortCodeDay($lottoRecord->created_at);
                    $itemAdd = [];
                    $itemAdd['slug'] = $lottoItem->prefix_sub_link.'/'.vsprintf($lottoItem->slug_date,[$dateString,$dateString]);
                    if (now()->diffInYears($lottoRecord->created_at) > 0) {
                        $itemAdd['changefreq'] = 'yearly';
                    }else{
                        if (now()->diffInMonths($lottoRecord->created_at) > 0) {
                            $itemAdd['changefreq'] = 'monthly';
                        }else{
                            if (now()->diff($lottoRecord->created_at)->days > 1) {
                                $itemAdd['changefreq'] = 'weekly';
                            }else{
                                $itemAdd['changefreq'] = 'daily';
                            }
                        }
                    }
                    $itemAdd['lastmod'] = $lottoRecord->created_at;
                    array_push($listItems,$itemAdd);
                }
                $strName = 'tinh-thanh/'.\Str::slug($lottoItem->name).'/'.$i;
                $path = public_path('sitemap/'.$strName);
                static::createXmlFile($listItems,$path);
            }
        }
    }
}