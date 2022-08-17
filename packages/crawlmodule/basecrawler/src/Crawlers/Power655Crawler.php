<?php
namespace crawlmodule\basecrawler\Crawlers;

use App\Models\Page;
use App\Models\Power655VietlottNow;

class Power655Crawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/power655';
    protected $crawlLink = 'https://xoso.me/kqxs-power-6-55-ket-qua-xo-so-power-6-55-vietlott-ngay-hom-nay.html';
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
        Page::query()->where('layout_show','power_6_55_vietlott_ngay_hom_nay')->update(['moreinfo'=>$strContent]);

        $listItems = $htmlDom->find('.power655.mega645');
        $countItemAdd = $this->crawlItems($listItems);
        $nextLink = $htmlDom->find('.loading-page a.primary');
        while (count($nextLink) > 0 && $countItemAdd > 0) {
            $html = $this->exeCurl($nextLink[0]->href);
            $htmlDom = str_get_html($html);
            if (!$htmlDom) return false;
            $listItems = $htmlDom->find('.power655.mega645');
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
            $itemPower = new Power655VietlottNow;
            $itemPower->name = trim(count($itemTitles) > 0 ? $itemTitles[0]->plaintext:'');
            preg_match('/(\d{1,2})-(\d{1,2})-(\d{4})/', $itemPower->name, $dates);
            if (count($dates) == 4) {
                $day = $dates[1] < 10 ? '0'.$dates[1]:$dates[1];
                $month = $dates[2] < 10 ? '0'.$dates[2]:$dates[2];
                $year = $dates[3];
                $code = $dates[3].$dates[2].$dates[1];
                $time = now()->createFromFormat('d/m/Y H:i:s',$day.'/'.$month.'/'.$year.' 18:30:00');
                $fullCode = $year.$month.$day;
                $itemPower->code = $code;
                $itemPower->time = $time->timestamp;
                $itemPower->fullCode = $fullCode;
                $itemPower->created_at = $time;
                $itemPower->updated_at = $time;
            }
            $oldItem = Power655VietlottNow::where('fullcode',$itemPower->fullCode)->first();
            if (isset($oldItem)) {
                continue;
            }
            $itemPower->act = 1;
            $itemPower->name_content = '<h2 class="tit-mien clearfix">'.(count($itemTitles) > 0 ? $this->convertContent($itemTitles[0]):'').'</h2>';
            $itemPower->content = '<ul class="results">'.(count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'').'</ul>';
            $itemPower->save();
            $count++;
        }
        return $count;
    }
}
