<?php
namespace crawlmodule\basecrawler\Crawlers;

use App\Models\StaticalCrawl;
use vanhenry\manager\model\VRoute as ModelVRoute;
class StaticalCrawlCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/statical';
    public function startCrawl()
    {
        set_time_limit(-1);
        foreach (StaticalCrawl::where('is_crawled',0)->get() as $itemStaticalCrawl) {
            $this->crawItem($itemStaticalCrawl);
        }
        return true;
    }
    public function crawItem($itemStaticalCrawl)
    {
        $html = $this->exeCurl($itemStaticalCrawl->target_link);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;
        $itemTitles = $htmlDom->find('title');
        $itemMetaDescriptions = $htmlDom->find('meta[name=description]');
        $itemMetaKeywords = $htmlDom->find('meta[name=keywords]');
        $itemNames = $htmlDom->find('h1');
        $itemMetaimgs = $htmlDom->find('meta[property=og:image]');
        $itemBreadcrum = $htmlDom->find('.breadcrumb a');
        if (count($itemBreadcrum) > 0) {
            $itemStaticalCrawl->breadcrum_name = $itemBreadcrum[count($itemBreadcrum)-1]->plaintext;
        }
        $itemStaticalCrawl->name = count($itemNames) > 0 ? $itemNames[0]->plaintext:'';
        $imgSrc = count($itemMetaimgs) > 0 ? $itemMetaimgs[0]->content:'';
        if (\Str::contains($imgSrc,'http')) {
            $itemStaticalCrawl->img = $this->saveImg($imgSrc,$this->imageSaveDir);
        }

        $itemStaticalCrawl->act = 1;
        $itemStaticalCrawl->count = 0;
        $itemStaticalCrawl->seo_title = count($itemTitles) > 0 ? $itemTitles[0]->plaintext:$itemStaticalCrawl->name;
        $itemStaticalCrawl->seo_key = count($itemMetaKeywords) > 0 ? $itemMetaKeywords[0]->content:$itemStaticalCrawl->name;
        $itemStaticalCrawl->seo_des = count($itemMetaDescriptions) > 0 ? $itemMetaDescriptions[0]->content:$itemStaticalCrawl->name;

        $itemStaticalCrawl->seo_title = $this->clearContent($itemStaticalCrawl->seo_title);
        $itemStaticalCrawl->seo_key = $this->clearContent($itemStaticalCrawl->seo_key);
        $itemStaticalCrawl->seo_des = $this->clearContent($itemStaticalCrawl->seo_des);

        $itemStaticalCrawl->created_at = now();
        $itemStaticalCrawl->updated_at = now();
        $itemStaticalCrawl->is_crawled = 1;

        $itemStaticalCrawl->save();

        $oldItemVroute = ModelVRoute::where('table','statical_crawls')->where('map_id',$itemStaticalCrawl->id)->first();
        if (!isset($oldItemVroute)) {
            $itemStaticalCrawl->slug = $this->processSlug($this->clearLink($itemStaticalCrawl->target_link));
            $itemStaticalCrawl->save();
            $this->inserVRouter($itemStaticalCrawl,'App\Http\Controllers\StaticalCrawlController@view');
        }
    }
}
