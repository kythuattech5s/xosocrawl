<?php
namespace crawlmodule\basecrawler\Crawlers;

use App\Models\Page;
use App\Models\Mega645VietlottNow;

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
        
        $boxContents = $htmlDom->find('.tbl-row-hover.clearfix');
        $strContent = "";
        foreach ($boxContents as $key => $itemBoxContent) {
            $contentAdd = $this->convertContent($itemBoxContent);
            $strContent .= vsprintf('<div class="%stbl-row-hover clearfix">%s</div>',[$key == 0 ? 'box ':'',$contentAdd]);
        }
        Page::query()->where('layout_show','mega_6_45_vietlott_ngay_hom_nay')->update(['moreinfo'=>$strContent]);

        $listItems = $htmlDom->find('.box.mega645');
        $countItemAdd = $this->crawlItems($listItems);
        $nextLink = $htmlDom->find('.loading-page a.primary');
        while (count($nextLink) > 0 && $countItemAdd > 0) {
            $html = $this->exeCurl($nextLink[0]->href);
            $htmlDom = str_get_html($html);
            if (!$htmlDom) return false;
            $listItems = $htmlDom->find('.box.mega645');
            $countItemAdd = $this->crawlItems($listItems);
            $nextLink = $htmlDom->find('.loading-page a.primary');
        }
        return true;
    }
    public function crawlItems($listItems)
    {
        $count = 0;
        foreach ($listItems as $item) {
            $itemTitles = $item->find('.tit-mien.clearfix');
            $itemContents = $item->find('.results');
            $itemMege = new Mega645VietlottNow;
            $itemMege->name = trim(count($itemTitles) > 0 ? $itemTitles[0]->plaintext:'');
            preg_match('/(\d{1,2})-(\d{1,2})-(\d{4})/', $itemMege->name, $dates);
            if (count($dates) == 4) {
                $day = $dates[1] < 10 ? '0'.$dates[1]:$dates[1];
                $month = $dates[2] < 10 ? '0'.$dates[2]:$dates[2];
                $year = $dates[3];
                $code = $dates[3].$dates[2].$dates[1];
                $time = now()->createFromFormat('d/m/Y H:i:s',$day.'/'.$month.'/'.$year.' 18:30:00');
                $fullCode = $year.$month.$day;
                $itemMege->code = $code;
                $itemMege->time = $time->timestamp;
                $itemMege->fullCode = $fullCode;
                $itemMege->created_at = $time;
                $itemMege->updated_at = $time;
            }
            $oldItem = Mega645VietlottNow::where('fullcode',$itemMege->fullCode)->first();
            if (isset($oldItem)) {
                continue;
            }
            $itemMege->act = 1;
            $itemMege->name_content = '<h2 class="tit-mien clearfix">'.(count($itemTitles) > 0 ? $this->convertContent($itemTitles[0]):'').'</h2>';
            $itemMege->content = '<ul class="results">'.(count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'').'</ul>';
            $itemMege->save();
            $count++;
        }
        return $count;
    }
}
