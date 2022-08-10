<?php
namespace crawlmodule\basecrawler\Crawlers;
use App\Models\LoganCategory;

class LoganCategoryCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/lo-gan';
    protected $linkCrawls = [
        "https://xoso.me/thong-ke-lo-gan-xo-so-mien-bac-xsmb.html",
        "https://xoso.me/lo-gan-mt-thong-ke-lo-gan-mien-trung.html",
        "https://xoso.me/lo-gan-mn-thong-ke-lo-gan-mien-nam.html"
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
        $itemOld = LoganCategory::where('slug',$this->clearLink($linkItem))->first();
        if (isset($itemOld)) return;
        $html = $this->exeCurl($linkItem);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;
        $itemNames = $htmlDom->find('h1');
        $itemTitles = $htmlDom->find('title');
        $itemMetaDescriptions = $htmlDom->find('meta[name=description]');
        $itemMetaKeywords = $htmlDom->find('meta[name=keywords]');
        $itemMetaimgs = $htmlDom->find('meta[property=og:image]');
        $itemContents = $htmlDom->find('.box.box-html');
        $listRalateLinks = $htmlDom->find('ul.list-html-link li');

        $itemLoganCategory = new LoganCategory;
        $itemLoganCategory->name = count($itemNames) > 0 ? $itemNames[0]->plaintext:$this->clearLink($linkItem);
        $itemLoganCategory->slug = $this->processSlug($this->clearLink($linkItem));

        $itemLoganCategory->content = count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'';
        $imgSrc = count($itemMetaimgs) > 0 ? $itemMetaimgs[0]->content:'';
        if (\Str::contains($imgSrc,'http')) {
            $itemLoganCategory->img = $this->saveImg($imgSrc,$this->imageSaveDir);
        }
        
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
        $itemLoganCategory->see_more_link = json_encode($arrSeeMore);

        $itemLoganCategory->act = 1;
        $itemLoganCategory->count = 0;
        $itemLoganCategory->seo_title = count($itemTitles) > 0 ? $itemTitles[0]->plaintext:$itemLoganCategory->name;
        $itemLoganCategory->seo_key = count($itemMetaKeywords) > 0 ? $itemMetaKeywords[0]->content:$itemLoganCategory->name;
        $itemLoganCategory->seo_des = count($itemMetaDescriptions) > 0 ? $itemMetaDescriptions[0]->content:$itemLoganCategory->name;

        $itemLoganCategory->seo_title = $this->clearContent($itemLoganCategory->seo_title);
        $itemLoganCategory->seo_key = $this->clearContent($itemLoganCategory->seo_key);
        $itemLoganCategory->seo_des = $this->clearContent($itemLoganCategory->seo_des);
        $itemLoganCategory->real_link = $linkItem;
        $itemLoganCategory->save();
        $this->inserVRouter($itemLoganCategory,'App\Http\Controllers\LoganCategoryController@view');
    }
}
