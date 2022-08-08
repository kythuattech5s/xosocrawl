<?php
namespace crawlmodule\basecrawler\Crawlers;

use App\Models\StaticalLotteryNorthern;
use vanhenry\manager\model\VRoute as ModelVRoute;

class StaticalLotteryNorthernCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/statical-lottery-northern';
    protected $linkCrawl = 'https://xoso.me/thong-ke-giai-dac-biet-xo-so-mien-bac-xsmb.html';
    public function startCrawl()
    {
        // StaticalLotteryNorthern::truncate();
        // ModelVRoute::where('table','statical_lottery_northerns')->delete();
        $html = $this->exeCurl($this->linkCrawl);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;
        $listItems = $htmlDom->find('.tab-panel.tab-auto a');
        foreach ($listItems as $key => $linkItem) {
            $this->crawItem($linkItem);
        }
        return true;
    }
    public function crawItem($linkItem)
    {
        $itemOld = StaticalLotteryNorthern::where('slug',$this->clearLink($linkItem))->first();
        if (isset($itemOld)) return;
        $html = $this->exeCurl($linkItem->href);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;
        $itemNames = $htmlDom->find('h1');
        $itemTitles = $htmlDom->find('title');
        $itemMetaDescriptions = $htmlDom->find('meta[name=description]');
        $itemMetaKeywords = $htmlDom->find('meta[name=keywords]');
        $itemMetaimgs = $htmlDom->find('meta[property=og:image]');
        $itemContents = $htmlDom->find('.box.box-html');

        $itemStaticalLotteryNorthern = new StaticalLotteryNorthern;
        $itemStaticalLotteryNorthern->name = count($itemNames) > 0 ? $itemNames[0]->plaintext:$this->clearLink($linkItem);
        $itemStaticalLotteryNorthern->slug = $this->processSlug($this->clearLink($linkItem->href));
        $itemStaticalLotteryNorthern->short_name = $linkItem->plaintext;
        
        $imgSrc = count($itemMetaimgs) > 0 ? $itemMetaimgs[0]->content:'';
        if (\Str::contains($imgSrc,'http')) {
            $itemStaticalLotteryNorthern->img = $this->saveImg($imgSrc,$this->imageSaveDir);
        }
        $listRalateLinks = $htmlDom->find('ul.list-html-link li');
        $arrSeeMore = [];
        foreach ($listRalateLinks as $key => $itemRalateLink) {
            $key = (string)$key;
            $linkItemRelate = $itemRalateLink->find('a');
            if (count($linkItemRelate) > 0) {
                $arrSeeMore[$key]['title'] = trim($linkItemRelate[0]->plaintext);
                $arrSeeMore[$key]['link'] = $this->clearLink($linkItemRelate[0]->href);
                $fullText = $itemRalateLink->plaintext;
                $position = strpos($fullText,$arrSeeMore[$key]['title']);
                $name = trim(str_replace(substr($fullText,$position),'',$fullText));
                $arrSeeMore[$key]['name'] = $name;
            }
        }
        $itemStaticalLotteryNorthern->related_link = json_encode($arrSeeMore);
        $itemStaticalLotteryNorthern->content = count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'';
        $itemStaticalLotteryNorthern->act = 1;
        $itemStaticalLotteryNorthern->count = 0;
        $itemStaticalLotteryNorthern->seo_title = count($itemTitles) > 0 ? $itemTitles[0]->plaintext:$itemStaticalLotteryNorthern->name;
        $itemStaticalLotteryNorthern->seo_key = count($itemMetaKeywords) > 0 ? $itemMetaKeywords[0]->content:$itemStaticalLotteryNorthern->name;
        $itemStaticalLotteryNorthern->seo_des = count($itemMetaDescriptions) > 0 ? $itemMetaDescriptions[0]->content:$itemStaticalLotteryNorthern->name;

        $itemStaticalLotteryNorthern->seo_title = $this->clearContent($itemStaticalLotteryNorthern->seo_title);
        $itemStaticalLotteryNorthern->seo_key = $this->clearContent($itemStaticalLotteryNorthern->seo_key);
        $itemStaticalLotteryNorthern->seo_des = $this->clearContent($itemStaticalLotteryNorthern->seo_des);
        $itemStaticalLotteryNorthern->save();

        $this->inserVRouter($itemStaticalLotteryNorthern,'App\Http\Controllers\StaticalLotteryNorthernController@view');
    }
}
