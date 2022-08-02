<?php

namespace Lotto\Processors;

use Lotto\Contracts\IXoSo;
use Lotto\Dtos\ResultObject;
use Lotto\Enums\CrawlStatus;
use Lotto\Helpers\LottoHelper;
use Lotto\Models\LottoItem;

abstract class AbstractXoSo implements IXoSo
{
    protected LottoItem $lottoItem;
    protected $dateCrawl;
    public function __construct(LottoItem $lottoItem)
    {
        $this->lottoItem = $lottoItem;
    }

    public function loadDomFromUrl()
    {
        $url = $this->getLinkByDate();
        if (LottoHelper::checkUrlExists($url)) {
            $dom = $this->_loadDomFromUrl($url);
            return $dom;
        }
    }
    public function getLinkByDate(): string
    {
        $link = $this->lottoItem->link_with_date;
        $lottoTime = $this->lottoItem->lottoTime;
        $count = substr_count($link, "%s");
        $params = array_fill(0, $count, $lottoTime->formatByType($this->getDateCrawl()));
        $link = vsprintf($link, $params);
        return $link;
    }
    public function parseTableResult(): ResultObject
    {
        $result = new ResultObject();
        $dom = $this->loadDomFromUrl();
        if (!$dom) {
            $result->setStatus(CrawlStatus::FAIL);
            $result->setNote('Dom null');
            return $result;
        }
        if (!$this->isRightDate($dom)) {
            $result->setStatus(CrawlStatus::NO_SPIN);
            $result->setNote('Date not match between database and dom html!');
            return $result;
        }
        return $result = $this->parsePrizes($dom);
    }
    protected function _loadDomFromUrl($url)
    {
        @include_once(__DIR__ . '/../Libs/simple_html_dom.php');
        $content = LottoHelper::requestUrl($url);
        $htmlDom = str_get_html($content);
        return $htmlDom;
    }
    protected function isRightDate($dom)
    {
        $currentDate = $this->getDateCrawl();
        $dateDom = $this->extractDateInDom($dom);
        if ($dateDom) {
            return $currentDate->year == $dateDom->year && $currentDate->month == $dateDom->month && $currentDate->day == $dateDom->day;
        }
        return false;
    }
    protected function extractDateInDom($dom)
    {
        $title = $dom->find('h2.tit-mien')[0];
        $text = $title ? $title->plaintext : '';
        preg_match('/(\d{1,2})-(\d{1,2})-(\d{4})/', $text, $dates);
        if (count($dates) > 3) {
            $date = now();
            $date->setDate($dates[3], $dates[2], $dates[1]);
            return $date;
        }
    }

    protected abstract function parsePrizes($dom): ResultObject;

    /**
     * Get the value of dateCrawl
     *
     * @return  mixed
     */
    public function getDateCrawl()
    {
        $date = isset($this->dateCrawl) ? $this->dateCrawl : now();
        return $date;
    }

    /**
     * Set the value of dateCrawl
     *
     * @param   mixed  $dateCrawl  
     *
     * @return  self
     */
    public function setDateCrawl($dateCrawl)
    {
        $this->dateCrawl = $dateCrawl;
        return $this;
    }
}
