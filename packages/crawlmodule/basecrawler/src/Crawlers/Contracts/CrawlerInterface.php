<?php
namespace crawlmodule\basecrawler\Crawlers\Contracts;
interface CrawlerInterface {
    public function exeCurl($url, $type = 'GET', $data = null, $headers = []);
    public function startCrawl();
}