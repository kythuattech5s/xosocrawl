<?php
namespace crawlmodule\basecrawler\Crawlers;
use App\Models\News;
class NewsCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/tin-tuc';
    protected $linkCrawl = "https://xoso.me/tin-tuc";
    public function startCrawl()
    {
        set_time_limit(-1);
        try {
            $html = $this->exeCurl($this->linkCrawl);
            $htmlDom = str_get_html($html);
            if (!$htmlDom) return false;
            $listItems = $htmlDom->find('.content .col-l ul li');
            $this->crawlItems($listItems);
            $nextLink = $htmlDom->find('.paging.txt-center.magb10 a.active')[0]->next_sibling();
            $count = 10;
            while (isset($nextLink) > 0 && $count < 20) {
                $html = $this->exeCurl($nextLink->href);
                $htmlDom = str_get_html($html);
                if (!$htmlDom) return false;
                $listItems = $htmlDom->find('.content .col-l ul li');
                $this->crawlItems($listItems);
                $nextLink = $htmlDom->find('.paging.txt-center.magb10 a.active')[0]->next_sibling();
                $count += 10;
            }
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }
    public function crawlItems($listItems)
    {
        foreach ($listItems as $item) {
            $itemLink = $item->find('a')[0];
            $itemTimeName = $item->find('span')[0]->plaintext;
            $imgSrc = str_replace('_120x120','',$item->find('img')[0]->src);
            $this->crawlItem($itemLink,$itemTimeName,$imgSrc);
        }
    }
    public function crawlItem($itemLink,$itemTimeName,$imgSrc)
    {
        $html = $this->exeCurl($itemLink->href);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;

        $itemTitles = $htmlDom->find('title');
        $itemMetaDescriptions = $htmlDom->find('meta[name=description]');
        $itemMetaKeywords = $htmlDom->find('meta[name=keywords]');
        $itemMetaimgs = $htmlDom->find('meta[property=og:image]');
        $itemNames = $htmlDom->find('h1');
        $itemContents = $htmlDom->find('.cont-detail.paragraph');

        $itemNews = new News;
        $itemNews->name = count($itemNames) > 0 ? $itemNames[0]->plaintext:$itemLink->plaintext;
        $itemNews->slug = $this->processSlug($this->clearLink(str_replace('https://xoso.me/tin-tuc/','',$itemLink->href)));

        if (\Str::contains($imgSrc,'http')) {
            $itemNews->img = $this->saveImg($imgSrc,$this->imageSaveDir);
        }

        $itemNews->content = count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'';
        $itemNews->act = 1;
        $itemNews->count = 0;
        $itemNews->seo_title = count($itemTitles) > 0 ? $itemTitles[0]->plaintext:$itemNews->name;
        $itemNews->seo_key = count($itemMetaKeywords) > 0 ? $itemMetaKeywords[0]->content:$itemNews->name;
        $itemNews->seo_des = count($itemMetaDescriptions) > 0 ? $itemMetaDescriptions[0]->content:$itemNews->name;

        $itemNews->seo_title = $this->clearContent($itemNews->seo_title);
        $itemNews->seo_key = $this->clearContent($itemNews->seo_key);
        $itemNews->seo_des = $this->clearContent($itemNews->seo_des);

        preg_match('/(\d{1,2})-(\d{1,2})-(\d{4})/', $itemTimeName, $dates);
        if (count($dates) == 4) {
            $day = $dates[1];
            $month = $dates[2];
            $year = $dates[3];
            $time = now()->createFromFormat('d/m/Y H:i:s',$day.'/'.$month.'/'.$year.' 00:00:00');
            $itemNews->created_at = $time;
            $itemNews->updated_at = $time;
        }
        $itemNews->save();
        $this->inserVRouter($itemNews,'App\Http\Controllers\NewsController@view');
        return true;
    }
}
