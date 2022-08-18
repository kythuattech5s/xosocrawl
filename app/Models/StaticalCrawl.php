<?php
namespace App\Models;

use crawlmodule\basecrawler\Crawlers\BaseCrawler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Support;

class StaticalCrawl extends BaseModel
{
    use HasFactory;
    public static function _getTime($type){
        switch ($type) {
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
            case 'vietlott':
                $time = now()->subDays(1);
                if (now()->hour == 18 && now()->minute >= 35) {
                    $time = now();
                }
                if (now()->hour > 18) {
                    $time = now();
                }
                return $time;
                break;
            default:
                return now();
                break;
        }
    }
    public function getTime()
    {
        return self::_getTime($this->time_type);
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
    public function getItemDataDirect($param = [])
    {
        $methodRequest = 'GET';
        $link = $this->target_link;
        if (isset(request()->page)) {
            $param['page'] = request()->page;
        }
        if (request()->isMethod('post')) {
            $methodRequest = 'POST';
        }
        $baseCrawler = new BaseCrawler;
        $html = $baseCrawler->exeCurl($link,$methodRequest,$param);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return null;
        $dataHtml = '';
        foreach (Support::extractJson($this->content_map) as $item) {
            $contentBox = $htmlDom->find($item['target']);
            if (count($contentBox) == 0) continue;
            $resultBooks = $contentBox[0]->find('#result-book');
            foreach ($resultBooks as $resultBook) {
                $resultBook->outertext = '';
            }
            $dataHtmlAdd = $baseCrawler->convertContent($contentBox[0],false);
            if (isset($item['cover'])) {
                $dataHtmlAdd = vsprintf($item['cover'],[$dataHtmlAdd]);
            }
            $dataHtml .= $dataHtmlAdd;
        }
        return $dataHtml;
    }
    public static function getBoxVietlottContentHome()
    {
        $itemActive = static::where('type','kq_xs_vietlott_hom_nay')->orderBy('id','desc')->first();
        $baseCrawler = new BaseCrawler;
        if (!isset($itemActive)) return '';
        $itemData = $itemActive->getItemData([]);
        if (!isset($itemData)) return '';
        $htmlDom = str_get_html($itemData->value);
        if (!$htmlDom) return null;
        $tabPanel = $htmlDom->find('.tab-panel');
        foreach ($tabPanel as $item) {
            $item->outertext = '';
        }
        $seeMore = $htmlDom->find('.see-more');
        foreach ($seeMore as $item) {
            $item->outertext = '';
        }
        $htmlBox = $htmlDom->find('.box');
        foreach ($htmlBox as $key => $item) {
            if ($key > 5) {
                $item->outertext = '';
            }
        }
        return (string)$htmlDom;
    }
    public static function getBoxShortContentLoganMienBac()
    {
        $itemActive = static::find(6);
        $baseCrawler = new BaseCrawler;
        if (!isset($itemActive)) return '';
        $itemData = $itemActive->getItemData([]);
        if (!isset($itemData)) return '';
        $htmlDom = str_get_html($itemData->value);
        if (!$htmlDom) return null;
        $listItem = $htmlDom->find('.box.tbl-row-hover');
        $ret = '';
        foreach ($listItem as $key => $item) {
            if ($key == 1 || $key == 2) {
                $itemBoxNotes = $item->find('.box.box-note');
                foreach ($itemBoxNotes as $itemBoxNote) {
                    $itemBoxNote->outertext = '';
                }
                $ret .= $item->innertext;   
            }
        }
        $ret .= '<div class="txt-right pad5"><a title="Thống kê lô gan" href="thong-ke-lo-gan-xo-so-mien-bac-xsmb">Xem thêm..</a></div>';
        return $ret;
    }
}
