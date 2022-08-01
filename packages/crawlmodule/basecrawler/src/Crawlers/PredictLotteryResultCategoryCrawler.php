<?php
namespace crawlmodule\basecrawler\Crawlers;
use App\Models\PredictLotteryResultCategory;
use vanhenry\manager\model\VRoute as ModelVRoute;

class PredictLotteryResultCategoryCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/predict-lottery-result-categoy';
    protected $linkCrawls = [
        "https://xoso.me/du-doan-ket-qua-xo-so-mien-bac-xsmb-c228.html",
        "https://xoso.me/du-doan-ket-qua-xo-so-mien-trung-xsmt-c224.html",
        "https://xoso.me/du-doan-ket-qua-xo-so-mien-nam-xsmn-c226.html"
    ];
    public function startCrawl()
    {
        // PredictLotteryResultCategory::truncate();
        // ModelVRoute::where('table','predict_lottery_result_categories')->delete();
        foreach ($this->linkCrawls as $key => $linkItem) {
            $this->crawItem($linkItem);
        }
        return true;
    }
    public function crawItem($linkItem)
    {
        $itemOld = PredictLotteryResultCategory::where('slug',$this->clearLink($linkItem))->first();
        if (isset($itemOld)) return;
        $html = $this->exeCurl($linkItem);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;
        $itemNames = $htmlDom->find('h1');
        $itemTitles = $htmlDom->find('title');
        $itemMetaDescriptions = $htmlDom->find('meta[name=description]');
        $itemMetaKeywords = $htmlDom->find('meta[name=keywords]');
        $itemContents = $htmlDom->find('.box.pad10.mag10');
        $itemShortContents = $htmlDom->find('.cate-news ul div.pad5 p');
        $itemRelatedLink = $htmlDom->find('.cate-news .tit-mien');

        $itemPredictLotteryResultCategory = new PredictLotteryResultCategory;
        $itemPredictLotteryResultCategory->name = count($itemNames) > 0 ? $itemNames[0]->plaintext:$this->clearLink($linkItem);
        $itemPredictLotteryResultCategory->slug = $this->processSlug($this->clearLink($linkItem));

        $itemPredictLotteryResultCategory->content = count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'';
        $itemPredictLotteryResultCategory->short_content = count($itemShortContents) > 0 ? $this->convertContent($itemShortContents[0]):'';
        $itemPredictLotteryResultCategory->related_link = count($itemRelatedLink) > 0 ? $this->convertContent($itemRelatedLink[0]):'';
        $itemPredictLotteryResultCategory->act = 1;
        $itemPredictLotteryResultCategory->count = 0;
        $itemPredictLotteryResultCategory->seo_title = count($itemTitles) > 0 ? $itemTitles[0]->plaintext:$itemPredictLotteryResultCategory->name;
        $itemPredictLotteryResultCategory->seo_key = count($itemMetaKeywords) > 0 ? $itemMetaKeywords[0]->content:$itemPredictLotteryResultCategory->name;
        $itemPredictLotteryResultCategory->seo_des = count($itemMetaDescriptions) > 0 ? $itemMetaDescriptions[0]->content:$itemPredictLotteryResultCategory->name;

        $itemPredictLotteryResultCategory->seo_title = $this->clearContent($itemPredictLotteryResultCategory->seo_title);
        $itemPredictLotteryResultCategory->seo_key = $this->clearContent($itemPredictLotteryResultCategory->seo_key);
        $itemPredictLotteryResultCategory->seo_des = $this->clearContent($itemPredictLotteryResultCategory->seo_des);
        $itemPredictLotteryResultCategory->real_link = $linkItem;

        $itemPredictLotteryResultCategory->save();

        $this->inserVRouter($itemPredictLotteryResultCategory,'App\Http\Controllers\PredictLotteryResultCategoryController@view');
    }
}
