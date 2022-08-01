<?php
namespace crawlmodule\basecrawler\Crawlers;
use App\Models\PredictLotteryResult;
use App\Models\PredictLotteryResultCategory;
use vanhenry\manager\model\VRoute as ModelVRoute;
class PredictLotteryResultCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/predict-lottery-result';
    public function startCrawl()
    {
        // PredictLotteryResult::truncate();
        // ModelVRoute::where('table','predict_lottery_results')->delete();
        set_time_limit(-1);
        ini_set("memory_limit",-1);
        $listPredictLotteryResultCategory = PredictLotteryResultCategory::get();
        foreach ($listPredictLotteryResultCategory as $key => $itemPredictLotteryResultCategory) {
            $html = $this->exeCurl($itemPredictLotteryResultCategory->real_link);
            $htmlDom = str_get_html($html);
            if (!$htmlDom) return false;

            $listItems = $htmlDom->find('.cate-news ul li.clearfix');
            $arrItemsInfo = $arrInfo = $this->getItemsInfo($listItems,$itemPredictLotteryResultCategory);
            $nextLink = $htmlDom->find('.loading-page a.primary');
            while (count($nextLink) > 0 && count($arrInfo) > 0) {
                $html = $this->exeCurl($nextLink[0]->href);
                $htmlDom = str_get_html($html);
                if (!$htmlDom) return false;
                $listItems = $htmlDom->find('.cate-news ul li.clearfix');
                $arrInfo = $this->getItemsInfo($listItems,$itemPredictLotteryResultCategory);
                foreach ($arrInfo as $itemInfo) {
                    array_push($arrItemsInfo,$itemInfo);
                }
                $nextLink = $htmlDom->find('.loading-page a.primary');
            }
            foreach (array_reverse($arrItemsInfo) as $item) {
                $this->crawItem($item['item_link'],$item['cate_id']);
            }
        }
        return true;
    }
    public function getItemsInfo($listItems,$itemPredictLotteryResultCategory)
    {
        $ret = [];
        foreach ($listItems as $key => $item) {
            $itemLinks = $item->find('a');
            if (count($itemLinks) == 0) continue;
            $itemOld = PredictLotteryResult::where('slug',$this->clearLink($itemLinks[0]->href))->first();
            if (isset($itemOld)) return $ret;
            $dataAdd = [
                'item_link' => $itemLinks[0],
                'cate_id' => $itemPredictLotteryResultCategory->id
            ];
            array_push($ret,$dataAdd);
        }
        return $ret;
    }
    public function crawItem($itemLink,$itemPredictLotteryResultCategoryId)
    {
        
        $html = $this->exeCurl($itemLink->href);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;
        $itemTitles = $htmlDom->find('title');
        $itemMetaDescriptions = $htmlDom->find('meta[name=description]');
        $itemMetaKeywords = $htmlDom->find('meta[name=keywords]');
        $itemMetaimgs = $htmlDom->find('meta[property=og:image]');
        $itemNames = $htmlDom->find('h1');
        $itemContents = $htmlDom->find('#article-content');
        $imageContents = count($itemContents) > 0 ? $itemContents[0]->find('img'):[];

        $itemPredictLotteryResult = new PredictLotteryResult;
        $itemPredictLotteryResult->name = count($itemNames) > 0 ? $itemNames[0]->plaintext:$itemLink->plaintext;
        $itemPredictLotteryResult->slug = $this->processSlug($this->clearLink($itemLink->href));
        $itemPredictLotteryResult->predict_lottery_result_category_id = $itemPredictLotteryResultCategoryId;

        $imgSrc = count($itemMetaimgs) > 0 ? $itemMetaimgs[0]->content:'';
        if (!\Str::contains($imgSrc,['http'])) {
            if (count($imageContents) > 0) {
                $imgSrc = $imageContents[0]->attr['src'] ?? '';
                if (!\Str::contains($imgSrc,'http')) {
                    $imgSrc = $imageContents[0]->attr['data-src'] ?? '';
                }
            }
        }
        if (\Str::contains($imgSrc,'http')) {
            $itemPredictLotteryResult->img = $this->saveImg($imgSrc,$this->imageSaveDir);
        }

        $itemPredictLotteryResult->content = count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'';
        $itemPredictLotteryResult->act = 1;
        $itemPredictLotteryResult->count = 0;
        $itemPredictLotteryResult->seo_title = count($itemTitles) > 0 ? $itemTitles[0]->plaintext:$itemPredictLotteryResult->name;
        $itemPredictLotteryResult->seo_key = count($itemMetaKeywords) > 0 ? $itemMetaKeywords[0]->content:$itemPredictLotteryResult->name;
        $itemPredictLotteryResult->seo_des = count($itemMetaDescriptions) > 0 ? $itemMetaDescriptions[0]->content:$itemPredictLotteryResult->name;

        $itemPredictLotteryResult->seo_title = $this->clearContent($itemPredictLotteryResult->seo_title);
        $itemPredictLotteryResult->seo_key = $this->clearContent($itemPredictLotteryResult->seo_key);
        $itemPredictLotteryResult->seo_des = $this->clearContent($itemPredictLotteryResult->seo_des);

        $itemPredictLotteryResult->save();

        $this->inserVRouter($itemPredictLotteryResult,'App\Http\Controllers\PredictLotteryResultController@view');
    }
}
