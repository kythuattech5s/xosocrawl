<?php
namespace crawlmodule\basecrawler\Crawlers;
use App\Models\DreamNumberDecoding;
class DreamnumberCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/dreamnumber';
    protected $linkCrawlListDreamNumberDecoding = "https://xoso.me/so-mo-lo-de-mien-bac-so-mo-giai-mong.html";
    public function startCrawl()
    {
        // DreamNumberDecoding::truncate();
        set_time_limit(-1);
        $html = $this->exeCurl($this->linkCrawlListDreamNumberDecoding);
        $htmlDom = str_get_html($html);
        $listItem = $htmlDom->find('.box-dream table tr');
        $this->crawItems($listItem);
        $nextLink = $htmlDom->find('.loading-page a.primary');
        while (count($nextLink) > 0) {
            $html = $this->exeCurl($nextLink[0]->href);
            $htmlDom = str_get_html($html);
            $listItem = $htmlDom->find('.box-dream table tr');
            $this->crawItems($listItem);
            $nextLink = $htmlDom->find('.loading-page a.primary');
        }
        return true;
    }
    public function crawItems($listItem)
    {
        foreach ($listItem as $key => $item) {
            if ($key == 0) continue;
            $itemInfo = $item->find('td');
            if (count($itemInfo) != 3) continue;
            $itemLinks = $itemInfo[1]->find('a');
            if (count($itemLinks) == 0) continue;
            $this->crawItem($itemLinks[0],$itemInfo[2]->plaintext);
        }
    }
    public function crawItem($itemLink,$itemNumber)
    {
        $html = $this->exeCurl($itemLink->href);
        $htmlDom = str_get_html($html);
        $itemTitles = $htmlDom->find('title');
        $itemMetaDescriptions = $htmlDom->find('meta[name=description]');
        $itemMetaKeywords = $htmlDom->find('meta[name=keywords]');
        $itemMetaimgs = $htmlDom->find('meta[property=og:image]');
        $itemNames = $htmlDom->find('h1');
        $itemContents = $htmlDom->find('.cont-dream');

        $itemDreamNumberDecoding = new DreamNumberDecoding;
        // $itemDreamNumberDecoding->name = count($itemNames) > 0 ? $itemNames[0]->plaintext:$itemLink->plaintext;
        // $itemDreamNumberDecoding->slug = $this->processSlug($this->clearLink($itemLink->href));
        // $itemDreamNumberDecoding->key_name = $itemLink->plaintext;
        // $itemDreamNumberDecoding->number_decoding = $itemNumber;
        // $itemDreamNumberDecoding->img = count($itemMetaimgs) > 0 ? $this->saveImg($itemMetaimgs[0]->content,$this->imageSaveDir):'';
        // $itemDreamNumberDecoding->content = count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'';
        // $itemDreamNumberDecoding->act = 1;
        // $itemDreamNumberDecoding->count = 0;
        // $itemDreamNumberDecoding->seo_title = count($itemTitles) > 0 ? $itemTitles[0]->plaintext:$itemDreamNumberDecoding->name;
        // $itemDreamNumberDecoding->seo_key = count($itemMetaKeywords) > 0 ? $itemMetaKeywords[0]->content:$itemDreamNumberDecoding->name;
        // $itemDreamNumberDecoding->seo_des = count($itemMetaDescriptions) > 0 ? $itemMetaDescriptions[0]->content:$itemDreamNumberDecoding->name;
        // $itemDreamNumberDecoding->save();

        $this->inserVRouter($itemDreamNumberDecoding,'App\Http\Controllers\DreamNumberDecodingController@view');

        dd($itemDreamNumberDecoding);
        // $itemDreamNumberDecoding = new DreamNumberDecoding;
    }
}
