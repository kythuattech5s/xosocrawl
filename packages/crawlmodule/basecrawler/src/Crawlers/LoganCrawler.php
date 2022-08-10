<?php
namespace crawlmodule\basecrawler\Crawlers;

use App\Models\Logan;
use vanhenry\manager\model\VRoute as ModelVRoute;
class LoganCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/lo-gan';
    public function startCrawl()
    {
        set_time_limit(-1);
        foreach (Logan::get() as $itemLogan) {
            $this->crawItem($itemLogan);
        }
        return true;
    }
    public function crawItem($itemLogan)
    {
        $html = $this->exeCurl($itemLogan->real_link);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;
        $itemTitles = $htmlDom->find('title');
        $itemMetaDescriptions = $htmlDom->find('meta[name=description]');
        $itemMetaKeywords = $htmlDom->find('meta[name=keywords]');
        $itemNames = $htmlDom->find('h1');
        $itemMetaimgs = $htmlDom->find('meta[property=og:image]');
        $itemContents = $htmlDom->find('.box.box-html');
        $itemLogan->name = count($itemNames) > 0 ? $itemNames[0]->plaintext:'';

        $imgSrc = count($itemMetaimgs) > 0 ? $itemMetaimgs[0]->content:'';
        if (\Str::contains($imgSrc,'http')) {
            $itemLogan->img = $this->saveImg($imgSrc,$this->imageSaveDir);
        }

        $itemLogan->content = count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'';
        $itemLogan->act = 1;
        $itemLogan->count = 0;
        $itemLogan->seo_title = count($itemTitles) > 0 ? $itemTitles[0]->plaintext:$itemLogan->name;
        $itemLogan->seo_key = count($itemMetaKeywords) > 0 ? $itemMetaKeywords[0]->content:$itemLogan->name;
        $itemLogan->seo_des = count($itemMetaDescriptions) > 0 ? $itemMetaDescriptions[0]->content:$itemLogan->name;

        $itemLogan->seo_title = $this->clearContent($itemLogan->seo_title);
        $itemLogan->seo_key = $this->clearContent($itemLogan->seo_key);
        $itemLogan->seo_des = $this->clearContent($itemLogan->seo_des);

        $itemLogan->save();

        $oldItemVroute = ModelVRoute::where('table',$itemLogan->getTable())->where('map_id',$itemLogan->id)->first();
        if (!isset($oldItemVroute)) {
            $itemLogan->slug = $this->processSlug($this->clearLink($itemLogan->real_link));
            $itemLogan->save();
            $this->inserVRouter($itemLogan,'App\Http\Controllers\LoganController@view');
        }
    }
}
