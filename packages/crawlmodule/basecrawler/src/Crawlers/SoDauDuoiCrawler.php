<?php
namespace crawlmodule\basecrawler\Crawlers;

use App\Models\SoDauDuoi;

class SoDauDuoiCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/so-dau-duoi';
    protected $linkCrawls = [
        "https://xoso.me/so-dau-duoi-mb.html",
        "https://xoso.me/so-dau-duoi-mt.html",
        "https://xoso.me/so-dau-duoi-mn.html"
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
        $itemOld = SoDauDuoi::where('slug',$this->clearLink($linkItem))->first();
        if (isset($itemOld)) return;
        $html = $this->exeCurl($linkItem);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;
        $itemNames = $htmlDom->find('h1');
        $itemShortNames = $htmlDom->find('.box .tit-mien.magb10');
        $itemTitles = $htmlDom->find('title');
        $itemMetaDescriptions = $htmlDom->find('meta[name=description]');
        $itemMetaKeywords = $htmlDom->find('meta[name=keywords]');
        $itemContents = $htmlDom->find('.box.box-html');
        $itemSeeMore = $htmlDom->find('.see-more');
        $itemMetaimgs = $htmlDom->find('meta[property=og:image]');

        $itemSoDauDuoi = new SoDauDuoi;
        $itemSoDauDuoi->name = count($itemNames) > 0 ? $itemNames[0]->plaintext:$this->clearLink($linkItem);
        $itemSoDauDuoi->slug = $this->processSlug($this->clearLink($linkItem));
        $imgSrc = count($itemMetaimgs) > 0 ? $itemMetaimgs[0]->content:'';
        if (\Str::contains($imgSrc,'http')) {
            $itemSoDauDuoi->img = $this->saveImg($imgSrc,$this->imageSaveDir);
        }
        
        $itemSoDauDuoi->short_name = count($itemShortNames) > 0 ? $itemShortNames[0]->plaintext:'';
        $itemSoDauDuoi->content = count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'';
        $itemSoDauDuoi->see_more = count($itemSeeMore) > 0 ? $this->convertContent($itemSeeMore[0]):'';
        $itemSoDauDuoi->act = 1;
        $itemSoDauDuoi->count = 0;
        $itemSoDauDuoi->seo_title = count($itemTitles) > 0 ? $itemTitles[0]->plaintext:$itemSoDauDuoi->name;
        $itemSoDauDuoi->seo_key = count($itemMetaKeywords) > 0 ? $itemMetaKeywords[0]->content:$itemSoDauDuoi->name;
        $itemSoDauDuoi->seo_des = count($itemMetaDescriptions) > 0 ? $itemMetaDescriptions[0]->content:$itemSoDauDuoi->name;

        $itemSoDauDuoi->seo_title = $this->clearContent($itemSoDauDuoi->seo_title);
        $itemSoDauDuoi->seo_key = $this->clearContent($itemSoDauDuoi->seo_key);
        $itemSoDauDuoi->seo_des = $this->clearContent($itemSoDauDuoi->seo_des);
        $itemSoDauDuoi->real_link = $linkItem;

        $itemSoDauDuoi->save();
        $this->inserVRouter($itemSoDauDuoi,'App\Http\Controllers\SoDauDuoiController@view');
    }
}
