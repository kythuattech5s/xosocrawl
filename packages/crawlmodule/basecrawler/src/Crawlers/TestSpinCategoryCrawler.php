<?php
namespace crawlmodule\basecrawler\Crawlers;
use App\Models\TestSpinCategory;
use vanhenry\manager\model\VRoute as ModelVRoute;

class TestSpinCategoryCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/test-spin';
    protected $linkCrawls = [
        "https://xoso.me/quay-thu-xsmb-quay-thu-xo-so-mien-bac.html",
        "https://xoso.me/quay-thu-xsmt-quay-thu-xo-so-mien-trung.html",
        "https://xoso.me/quay-thu-xsmn-quay-thu-xo-so-mien-nam.html"
    ];
    public function startCrawl()
    {
        // TestSpinCategory::truncate();
        // ModelVRoute::where('table','test_spin_categories')->delete();
        foreach ($this->linkCrawls as $key => $linkItem) {
            $this->crawItem($linkItem);
        }
        return true;
    }
    public function crawItem($linkItem)
    {
        $itemOld = TestSpinCategory::where('slug',$this->clearLink($linkItem))->first();
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

        $itemTestSpinCategory = new TestSpinCategory;
        $itemTestSpinCategory->name = count($itemNames) > 0 ? $itemNames[0]->plaintext:$this->clearLink($linkItem);
        $itemTestSpinCategory->slug = $this->processSlug($this->clearLink($linkItem));
        $imgSrc = count($itemMetaimgs) > 0 ? $itemMetaimgs[0]->content:'';
        if (\Str::contains($imgSrc,'http')) {
            $itemTestSpinCategory->img = $this->saveImg($imgSrc,$this->imageSaveDir);
        }

        $itemTestSpinCategory->content = count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'';
        $itemTestSpinCategory->act = 1;
        $itemTestSpinCategory->count = 0;
        $itemTestSpinCategory->seo_title = count($itemTitles) > 0 ? $itemTitles[0]->plaintext:$itemTestSpinCategory->name;
        $itemTestSpinCategory->seo_key = count($itemMetaKeywords) > 0 ? $itemMetaKeywords[0]->content:$itemTestSpinCategory->name;
        $itemTestSpinCategory->seo_des = count($itemMetaDescriptions) > 0 ? $itemMetaDescriptions[0]->content:$itemTestSpinCategory->name;

        $itemTestSpinCategory->seo_title = $this->clearContent($itemTestSpinCategory->seo_title);
        $itemTestSpinCategory->seo_key = $this->clearContent($itemTestSpinCategory->seo_key);
        $itemTestSpinCategory->seo_des = $this->clearContent($itemTestSpinCategory->seo_des);
        $itemTestSpinCategory->real_link = $linkItem;

        $itemTestSpinCategory->save();

        $this->inserVRouter($itemTestSpinCategory,'App\Http\Controllers\TestSpinCategoryController@view');
    }
}
