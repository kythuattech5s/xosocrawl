<?php
namespace App\Models;

use crawlmodule\basecrawler\Crawlers\BaseCrawler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Support;

class StaticalCrawl extends BaseModel
{
    use HasFactory;
    public function getTime()
    {
        switch ($this->time_type) {
            case 'bac':
                $time = now()->subDays(1);
                if (now()->hour == 18 && now()->minute >= 40) {
                    $time = now();
                }
                if (now()->hour > 18) {
                    $time = now();
                }
                return $time;
                break;
            case 'trung':
                $time = now()->subDays(1);
                if (now()->hour == 17 && now()->minute >= 40) {
                    $time = now();
                }
                if (now()->hour > 17) {
                    $time = now();
                }
                return $time;
                break;
            case 'nam':
                $time = now()->subDays(1);
                if (now()->hour == 16 && now()->minute >= 40) {
                    $time = now();
                }
                if (now()->hour > 16) {
                    $time = now();
                }
                return $time;
                break;
            default:
                return now();
                break;
        }
    }
    public function timeToFullCode($time)
    {
        return $time->year.$time->format('m').$time->format('d');
    }
    public function getItemData($param = [])
    {
        $time = $this->getTime();
        $strIdentify = $this->id;
        $strIdentify .= $this->type;
        $strIdentify .= $this->timeToFullCode($time);
        if (isset($param) && count($param) > 0) {
            $strIdentify .= json_encode($param);
        }
        $identify = md5($strIdentify);
        $methodRequest = 'GET';
        if (request()->isMethod('post')) {
            $methodRequest = 'POST';
        }
        if (!StaticalCrawlData::checkExist($identify)) {
            $baseCrawler = new BaseCrawler;
            $html = $baseCrawler->exeCurl($this->target_link,$methodRequest,$param);
            $htmlDom = str_get_html($html);
            if (!$htmlDom) return null;
            $dataHtml = '';
            foreach (Support::extractJson($this->content_map) as $item) {
                $contentBox = $htmlDom->find($item['target']);
                if (count($contentBox) == 0) continue;
                $dataHtmlAdd = $baseCrawler->convertContent($contentBox[0]);
                if (isset($item['cover'])) {
                    $dataHtmlAdd = vsprintf($item['cover'],[$dataHtmlAdd]);
                }
                $dataHtml .= $dataHtmlAdd;
            }
            return StaticalCrawlData::createItem($this->id,$identify,$dataHtml,$time,$param);
        }
        return StaticalCrawlData::getItem($identify);
    }
}
