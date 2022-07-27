<?php
namespace crawlmodule\basecrawler\Crawlers;
use crawlmodule\basecrawler\Crawlers\Contracts\CrawlerInterface;
class BaseCrawler implements CrawlerInterface
{
    protected $clearLinkCharacters = [
        'https://xoso.me',
        '.html'
    ];
    public function __construct()
    {
        @include_once ('simple_html_dom.php');
    }
    public function exeCurl($url, $type = 'GET', $data = null, $headers = [])
    {
        $curl = curl_init();
        $params = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $type,
            CURLOPT_FOLLOWLOCATION => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        );
        if ($type == 'POST' && is_string($data)) {
            $params[CURLOPT_POSTFIELDS] = $data;
        }
        if ($type == 'POST' && is_array($data)) {
            $params[CURLOPT_POSTFIELDS] = http_build_query($data);
        }
        if ($type == 'GET' && is_array($data)) {
            $params[CURLOPT_URL] = $url . '?' . http_build_query($data);
        }
        if ($headers) {
            $params[CURLOPT_HTTPHEADER] = $headers;
        }
        curl_setopt_array($curl, $params);
        $res = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);
        if (!empty($err)) {
            return $err;
        }
        return $res;
    }
    public function startCrawl()
    {
        return true;
    }
    public function clearLink($link)
    {
        foreach ($this->clearLinkCharacters as $itemClearCharacter) {
            $link = str_replace($itemClearCharacter,'',$link);
        }
        $link = trim($link);
        $link = trim($link,'/');
        return $link;
    }
}
