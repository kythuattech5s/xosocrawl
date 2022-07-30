<?php
namespace crawlmodule\basecrawler\Crawlers;
use App\Models\DreamNumberDecoding;
use vanhenry\manager\model\VRoute as ModelVRoute;
class DreamNumberCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/dreamnumber';
    protected $linkCrawlListDreamNumberDecoding = "https://xoso.me/so-mo-lo-de-mien-bac-so-mo-giai-mong.html";
    public function startCrawl()
    {
        // DreamNumberDecoding::truncate();
        // ModelVRoute::where('table','dream_number_decodings')->delete();
        set_time_limit(-1);

        $html = $this->exeCurl($this->linkCrawlListDreamNumberDecoding);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;
        $listItem = $htmlDom->find('.box-dream table tr');
        $this->crawItems($listItem);
        $nextLink = $htmlDom->find('.loading-page a.primary');
        while (count($nextLink) > 0) {
            $html = $this->exeCurl($nextLink[0]->href);
            $htmlDom = str_get_html($html);
            if (!$htmlDom) return false;
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
        $itemOld = DreamNumberDecoding::where('slug',$this->clearLink($itemLink->href))->first();
        if (isset($itemOld)) return;
        $html = $this->exeCurl($itemLink->href);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;
        $itemTitles = $htmlDom->find('title');
        $itemMetaDescriptions = $htmlDom->find('meta[name=description]');
        $itemMetaKeywords = $htmlDom->find('meta[name=keywords]');
        $itemMetaimgs = $htmlDom->find('meta[property=og:image]');
        $itemNames = $htmlDom->find('h1');
        $itemContents = $htmlDom->find('.cont-dream');
        $imageContents = count($itemContents) > 0 ? $itemContents[0]->find('img'):[];

        $itemDreamNumberDecoding = new DreamNumberDecoding;
        $itemDreamNumberDecoding->name = count($itemNames) > 0 ? $itemNames[0]->plaintext:$itemLink->plaintext;
        $itemDreamNumberDecoding->slug = $this->processSlug($this->clearLink($itemLink->href));
        $itemDreamNumberDecoding->key_name = $itemLink->plaintext;
        $itemDreamNumberDecoding->number_decoding = $itemNumber;

        $imgSrc = '';
        if (count($imageContents) > 0) {
            $imgSrc = $imageContents[0]->attr['src'] ?? '';
            if (!\Str::contains($imgSrc,'http')) {
                $imgSrc = $imageContents[0]->attr['data-src'] ?? '';
            }
        }
        if (!\Str::contains($imgSrc,['http'])) {
            $imgSrc = count($itemMetaimgs) > 0 ? $itemMetaimgs[0]->content:'';
        }
        if (\Str::contains($imgSrc,'http')) {
            $itemDreamNumberDecoding->img = $this->saveImg($imgSrc,$this->imageSaveDir);
        }

        $itemDreamNumberDecoding->content = count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'';
        $itemDreamNumberDecoding->act = 1;
        $itemDreamNumberDecoding->count = 0;
        $itemDreamNumberDecoding->seo_title = count($itemTitles) > 0 ? $itemTitles[0]->plaintext:$itemDreamNumberDecoding->name;
        $itemDreamNumberDecoding->seo_key = count($itemMetaKeywords) > 0 ? $itemMetaKeywords[0]->content:$itemDreamNumberDecoding->name;
        $itemDreamNumberDecoding->seo_des = count($itemMetaDescriptions) > 0 ? $itemMetaDescriptions[0]->content:$itemDreamNumberDecoding->name;

        $itemDreamNumberDecoding->seo_title = $this->clearContent($itemDreamNumberDecoding->seo_title);
        $itemDreamNumberDecoding->seo_key = $this->clearContent($itemDreamNumberDecoding->seo_key);
        $itemDreamNumberDecoding->seo_des = $this->clearContent($itemDreamNumberDecoding->seo_des);

        $itemDreamNumberDecoding->save();

        $this->inserVRouter($itemDreamNumberDecoding,'App\Http\Controllers\DreamNumberDecodingController@view');
    }
}
