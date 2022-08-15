<?php
namespace crawlmodule\basecrawler\Crawlers;
class Mege645Crawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/mega645';
    protected $crawlLink = 'https://xoso.me/kqxs-mega-645-ket-qua-xo-so-mega-6-45-vietlott-ngay-hom-nay.html';
    public function startCrawl()
    {
        set_time_limit(-1);
        $html = $this->exeCurl($this->crawlLink);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;
        $nextLink = $htmlDom->find('.loading-page a.primary');
        while (count($nextLink) > 0) {
            $html = $this->exeCurl($nextLink[0]->href);
            $htmlDom = str_get_html($html);
            if (!$htmlDom) return false;
            echo $nextLink[0]->href.PHP_EOL;
            $nextLink = $htmlDom->find('.loading-page a.primary');
        }
        return true;
    }
}
