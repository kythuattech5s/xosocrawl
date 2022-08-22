<?php
namespace crawlmodule\basecrawler\Crawlers;
use App\Models\PredictLotteryProvinceResult;
use App\Models\PredictLotteryResultCategory;
class PredictLotteryProvinceResultCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/predict-lottery-province-result';
    protected $linkCrawl = "https://xoso.me/";
    public function startCrawl()
    {
        set_time_limit(-1);
        $html = $this->exeCurl($this->linkCrawl);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;

        $boxItems = $htmlDom->find('.stastic-lotery.two-column');
        if (count($boxItems) == 2) {
            $boxItem = $boxItems[1];
            $listItems = $boxItem->find('a');
            $arrActiveItemId = [];
            foreach ($listItems as $key => $itemLink) {
                if (!\Str::contains($itemLink->plaintext,'Dự đoán')) continue;
                $oldItem = PredictLotteryProvinceResult::where('slug',$this->clearLink($itemLink->href))->first();
                if (!isset($oldItem)) {
                    $itemId = $this->crawItem($itemLink);
                    array_push($arrActiveItemId,$itemId);
                }else{
                    if ($this->recrawlContentItem($itemLink,$oldItem)) {
                        array_push($arrActiveItemId,$oldItem->id);
                    }
                }
            }
            PredictLotteryProvinceResult::query()->update(['show_sidebar'=>0]);
            PredictLotteryProvinceResult::whereIn('id',$arrActiveItemId)->update(['show_sidebar'=>1]);
        }
        return true;
    }
    public function recrawlContentItem($itemLink,$oldItem)
    {
        $html = $this->exeCurl($itemLink->href);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;
        $itemShowNames = $htmlDom->find('.dudoantinh .s20.mag10.pad10');
        $itemContents = $htmlDom->find('.box-html.cont-detail.paragraph');
        $oldItem->show_name = count($itemShowNames) > 0 ? $itemShowNames[0]->plaintext:$itemLink->plaintext;
        $oldItem->content = count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'';
        $oldItem->save();
        return $oldItem->id;
    }
    public function crawItem($itemLink)
    {
        $html = $this->exeCurl($itemLink->href);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;
        $itemTitles = $htmlDom->find('title');
        $itemMetaDescriptions = $htmlDom->find('meta[name=description]');
        $itemMetaKeywords = $htmlDom->find('meta[name=keywords]');
        $itemMetaimgs = $htmlDom->find('meta[property=og:image]');
        $itemNames = $htmlDom->find('h1');
        $itemShowNames = $htmlDom->find('.dudoantinh .s20.mag10.pad10');
        $itemContents = $htmlDom->find('.box-html.cont-detail.paragraph');
        $imageContents = count($itemContents) > 0 ? $itemContents[0]->find('img'):[];
        $itemBreadcrumbs = $htmlDom->find('.breadcrumb a');

        $itemPredictLotteryProvinceResult = new PredictLotteryProvinceResult;
        $itemPredictLotteryProvinceResult->name = count($itemNames) > 0 ? $itemNames[0]->plaintext:$itemLink->plaintext;
        $itemPredictLotteryProvinceResult->show_name = count($itemShowNames) > 0 ? $itemShowNames[0]->plaintext:$itemLink->plaintext;
        $itemPredictLotteryProvinceResult->province_name = trim(str_replace('Dự đoán','',$itemLink->plaintext));
        $itemPredictLotteryProvinceResult->slug = $this->processSlug($this->clearLink($itemLink->href));
        if (count($itemBreadcrumbs) == 3) {
            $itemCate = PredictLotteryResultCategory::where('slug',$this->clearLink($itemBreadcrumbs[1]->href))->first();
            if (isset($itemCate)) {
                $itemPredictLotteryProvinceResult->predict_lottery_result_category_id = $itemCate->id;
            }
        }
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
            $itemPredictLotteryProvinceResult->img = $this->saveImg($imgSrc,$this->imageSaveDir);
        }
        $itemPredictLotteryProvinceResult->content = count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'';
        $itemPredictLotteryProvinceResult->act = 1;
        $itemPredictLotteryProvinceResult->count = 0;
        $itemPredictLotteryProvinceResult->seo_title = count($itemTitles) > 0 ? $itemTitles[0]->plaintext:$itemPredictLotteryProvinceResult->name;
        $itemPredictLotteryProvinceResult->seo_key = count($itemMetaKeywords) > 0 ? $itemMetaKeywords[0]->content:$itemPredictLotteryProvinceResult->name;
        $itemPredictLotteryProvinceResult->seo_des = count($itemMetaDescriptions) > 0 ? $itemMetaDescriptions[0]->content:$itemPredictLotteryProvinceResult->name;

        $itemPredictLotteryProvinceResult->seo_title = $this->clearContent($itemPredictLotteryProvinceResult->seo_title);
        $itemPredictLotteryProvinceResult->seo_key = $this->clearContent($itemPredictLotteryProvinceResult->seo_key);
        $itemPredictLotteryProvinceResult->seo_des = $this->clearContent($itemPredictLotteryProvinceResult->seo_des);
        $itemPredictLotteryProvinceResult->save();
        $this->inserVRouter($itemPredictLotteryProvinceResult,'App\Http\Controllers\PredictLotteryProvinceResultController@view');
        return $itemPredictLotteryProvinceResult->id;
    }
}
