<?php
namespace crawlmodule\basecrawler\Crawlers\Factory;
class CrawlerFactory{
    public static function getCrawler($type){
        $className = ucfirst($type).'Crawler';
        $classTarget = vsprintf('crawlmodule\basecrawler\Crawlers\\%s',[$className]);
        if (!class_exists($classTarget)) {
            throw new \Exception("Class ".$className." not found.", 404);
        }
        return new $classTarget;
    }
}