<?php
namespace crawlmodule\basecrawler\Crawlers;

use App\Models\XosoTrucTiepItem;

class XosoTrucTiepItemCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/xoso-truc-tiep';
    protected $linkCrawls = [
        "https://xoso.me/xo-so-truc-tiep/xsmb-mien-bac.html",
        "https://xoso.me/xo-so-truc-tiep/xsmn-mien-nam.html",
        "https://xoso.me/xo-so-truc-tiep/xsmt-mien-trung.html"
    ];
    public function startCrawl()
    {
        foreach ($this->linkCrawls as $key => $linkItem) {
            $this->crawItem($linkItem);
        }
        return true;
    }
    public function crawItem($linkItem)
    {
        $html = $this->exeCurl($linkItem);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;
        $itemNames = $htmlDom->find('h1');
        $itemTitles = $htmlDom->find('title');
        $itemMetaimgs = $htmlDom->find('meta[property=og:image]');
        $itemMetaDescriptions = $htmlDom->find('meta[name=description]');
        $itemMetaKeywords = $htmlDom->find('meta[name=keywords]');
        $itemContents = $htmlDom->find('.box.box-html');
        $itemSeeMores = $htmlDom->find('.see-more');

        $itemXosoTrucTiepItem = new XosoTrucTiepItem;
        $itemXosoTrucTiepItem->name = count($itemNames) > 0 ? $itemNames[0]->plaintext:$this->clearLink($linkItem);
        $itemXosoTrucTiepItem->prefix_link = str_replace('xo-so-truc-tiep/','',$this->clearLink($linkItem));
        $imgSrc = count($itemMetaimgs) > 0 ? $itemMetaimgs[0]->content:'';
        if (\Str::contains($imgSrc,'http')) {
            $itemXosoTrucTiepItem->img = $this->saveImg($imgSrc,$this->imageSaveDir);
        }
        $itemXosoTrucTiepItem->seemore_box = count($itemSeeMores) > 0 ? $this->convertContent($itemSeeMores[0]):'';
        $itemXosoTrucTiepItem->content = count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'';
        $itemXosoTrucTiepItem->act = 1;
        $itemXosoTrucTiepItem->count = 0;
        $itemXosoTrucTiepItem->seo_title = count($itemTitles) > 0 ? $itemTitles[0]->plaintext:$itemXosoTrucTiepItem->name;
        $itemXosoTrucTiepItem->seo_key = count($itemMetaKeywords) > 0 ? $itemMetaKeywords[0]->content:$itemXosoTrucTiepItem->name;
        $itemXosoTrucTiepItem->seo_des = count($itemMetaDescriptions) > 0 ? $itemMetaDescriptions[0]->content:$itemXosoTrucTiepItem->name;

        $itemXosoTrucTiepItem->seo_title = $this->clearContent($itemXosoTrucTiepItem->seo_title);
        $itemXosoTrucTiepItem->seo_key = $this->clearContent($itemXosoTrucTiepItem->seo_key);
        $itemXosoTrucTiepItem->seo_des = $this->clearContent($itemXosoTrucTiepItem->seo_des);

        $itemXosoTrucTiepItem->save();
    }
}
