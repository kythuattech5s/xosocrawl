<?php
namespace crawlmodule\basecrawler\Controllers;
use Illuminate\Routing\Controller as BaseController;
use crawlmodule\basecrawler\Crawlers\Factory\CrawlerFactory;
class Controller extends BaseController
{
    public function doCrawl($type)
    {
        $crawler = CrawlerFactory::getCrawler($type);
        $status = $crawler->startCrawl();
        if ($status) {
            echo 'Thành công';
            return;
        }
        echo 'Đã có lỗi gì đó xảy ra.';
    }
}