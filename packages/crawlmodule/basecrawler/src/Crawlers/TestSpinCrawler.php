<?php
namespace crawlmodule\basecrawler\Crawlers;
use App\Models\TestSpin;
use vanhenry\manager\model\VRoute as ModelVRoute;
class TestSpinCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/test-spin';
    public function startCrawl()
    {
        set_time_limit(-1);
        foreach (TestSpin::get() as $itemTestSpin) {
            $this->crawItem($itemTestSpin);
        }
        return true;
    }
    public function crawItem($itemTestSpin)
    {
        $html = $this->exeCurl($itemTestSpin->real_link);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;
        $itemActive = $htmlDom->find('#province_name option[selected]');
        if (count($itemActive) > 0) {
            $itemTestSpin->province_name = $itemActive[0]->plaintext;
            $itemTestSpin->province_code = $itemActive[0]->value;
        }
        $itemTitles = $htmlDom->find('title');
        $itemMetaDescriptions = $htmlDom->find('meta[name=description]');
        $itemMetaKeywords = $htmlDom->find('meta[name=keywords]');
        $itemNames = $htmlDom->find('h1');
        $itemMetaimgs = $htmlDom->find('meta[property=og:image]');
        $itemContents = $htmlDom->find('.box.box-html');
        $itemTestSpin->name = count($itemNames) > 0 ? $itemNames[0]->plaintext:'';

        $imgSrc = count($itemMetaimgs) > 0 ? $itemMetaimgs[0]->content:'';
        if (\Str::contains($imgSrc,'http')) {
            $itemTestSpin->img = $this->saveImg($imgSrc,$this->imageSaveDir);
        }

        $itemTestSpin->content = count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'';
        $itemTestSpin->act = 1;
        $itemTestSpin->count = 0;
        $itemTestSpin->seo_title = count($itemTitles) > 0 ? $itemTitles[0]->plaintext:$itemTestSpin->name;
        $itemTestSpin->seo_key = count($itemMetaKeywords) > 0 ? $itemMetaKeywords[0]->content:$itemTestSpin->name;
        $itemTestSpin->seo_des = count($itemMetaDescriptions) > 0 ? $itemMetaDescriptions[0]->content:$itemTestSpin->name;

        $itemTestSpin->seo_title = $this->clearContent($itemTestSpin->seo_title);
        $itemTestSpin->seo_key = $this->clearContent($itemTestSpin->seo_key);
        $itemTestSpin->seo_des = $this->clearContent($itemTestSpin->seo_des);

        $itemTestSpin->save();

        $oldItemVroute = ModelVRoute::where('table','test_spins')->where('map_id',$itemTestSpin->id)->first();
        if (!isset($oldItemVroute)) {
            $itemTestSpin->slug = $this->processSlug($this->clearLink($itemTestSpin->real_link));
            $itemTestSpin->save();
            $this->inserVRouter($itemTestSpin,'App\Http\Controllers\TestSpinController@view');
        }
    }
}
