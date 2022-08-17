<?php
namespace crawlmodule\basecrawler\Crawlers;

use App\Models\DienToanThanTai;

class DienToanThanTaiCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/dien-toan-than-tai';
    protected $crawlLink = 'https://xoso.me/xo-so-dien-toan-than-tai-hom-nay.html';
    protected $nextlLink = 'https://xoso.me/xo-so-dien-toan-than-tai-hom-nay/%s.html';
    public function startCrawl()
    {
        set_time_limit(-1);
        $html = $this->exeCurl($this->crawlLink);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;

        $listItems = $htmlDom->find('.dientoan-ball.clearfix .box');
        $countItemAdd = $this->crawlItems($listItems,$htmlDom);
        $page = 1;
        while (count($listItems) > 0 && $countItemAdd > 0) {
            $page++;
            $html = $this->exeCurl(vsprintf($this->nextlLink,[$page]));
            $htmlDom = str_get_html($html);
            if (!$htmlDom) return false;
            $listItems = $htmlDom->find('.dientoan-ball.clearfix .box');
            $countItemAdd = $this->crawlItems($listItems,$htmlDom);
        }
        return true;
    }
    public function crawlItems($listItems)
    {
        $count = 0;
        foreach ($listItems as $item) {
            $itemTitles = $item->find('.tit-mien');
            $itemContents = $item->find('li');
            $listNumber = $item->find('span');
            $strNumber = '';
            foreach ($listNumber as $itemNumber) {
                $strNumber .= $itemNumber->plaintext.',';
            }
            $itemAdd = new DienToanThanTai;
            $itemAdd->name = trim(count($itemTitles) > 0 ? $itemTitles[0]->plaintext:'');
            preg_match('/(\d{1,2})-(\d{1,2})-(\d{4})/', str_replace('/','-',$itemAdd->name), $dates);
            if (count($dates) == 4) {
                $day = $dates[1] < 10 ? $dates[1]:$dates[1];
                $month = $dates[2] < 10 ? $dates[2]:$dates[2];
                $year = $dates[3];
                $code = $dates[3].$dates[2].$dates[1];
                $time = now()->createFromFormat('d/m/Y H:i:s',$day.'/'.$month.'/'.$year.' 18:05:00');
                $fullCode = $year.$month.$day;
                $itemAdd->code = $code;
                $itemAdd->time = $time->timestamp;
                $itemAdd->fullCode = $fullCode;
                $itemAdd->created_at = $time;
                $itemAdd->updated_at = $time;
            }
            $oldItem = DienToanThanTai::where('fullcode',$itemAdd->fullCode)->first();
            if (isset($oldItem)) {
                continue;
            }
            $itemAdd->act = 1;
            $itemAdd->name_content = '<h2 class="tit-mien">'.(count($itemTitles) > 0 ? $this->convertContent($itemTitles[0]):'').'</h2>';
            $itemAdd->content = '<li>'.(count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'').'</li>';
            $itemAdd->list_number = trim($strNumber,',');
            $itemAdd->save();
            $count++;
        }
        return $count;
    }
}
