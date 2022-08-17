<?php
namespace crawlmodule\basecrawler\Crawlers;

use App\Models\Max3dProVietlott;

class Max3dProCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/max3dpro';
    protected $crawlLink = 'https://xoso.me/xo-so-max3d-pro.html';
    public function startCrawl()
    {
        set_time_limit(-1);
        $html = $this->exeCurl($this->crawlLink);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;

        $listItems = $htmlDom->find('.tit-mien.clearfix');
        $countItemAdd = $this->crawlItems($listItems,$htmlDom);
        $nextLink = $htmlDom->find('.loading-page a.primary');
        while (count($nextLink) > 0 && $countItemAdd > 0) {
            $html = $this->exeCurl($nextLink[0]->href);
            $htmlDom = str_get_html($html);
            if (!$htmlDom) return false;
            $listItems = $htmlDom->find('.tit-mien.clearfix');
            $countItemAdd = $this->crawlItems($listItems,$htmlDom);
            $nextLink = $htmlDom->find('.loading-page a.primary');
        }
        return true;
    }
    public function crawlItems($listItems,$baseDom)
    {
        $count = 0;
        foreach ($listItems as $key => $item) {
            $itemContents = $baseDom->find('#load_kq_3dpro_'.$key);
            $itemMax3dPro = new Max3dProVietlott;
            $itemMax3dPro->name = trim($item->plaintext);
            preg_match('/(\d{1,2})-(\d{1,2})-(\d{4})/', $itemMax3dPro->name, $dates);
            if (count($dates) == 4) {
                $day = $dates[1] < 10 ? '0'.$dates[1]:$dates[1];
                $month = $dates[2] < 10 ? '0'.$dates[2]:$dates[2];
                $year = $dates[3];
                $code = $dates[3].$dates[2].$dates[1];
                $time = now()->createFromFormat('d/m/Y H:i:s',$day.'/'.$month.'/'.$year.' 18:30:00');
                $fullCode = $year.$month.$day;
                $itemMax3dPro->code = $code;
                $itemMax3dPro->time = $time->timestamp;
                $itemMax3dPro->fullCode = $fullCode;
                $itemMax3dPro->created_at = $time;
                $itemMax3dPro->updated_at = $time;
            }
            $oldItem = Max3dProVietlott::where('fullcode',$itemMax3dPro->fullCode)->first();
            if (isset($oldItem)) {
                continue;
            }
            $itemMax3dPro->act = 1;
            $itemMax3dPro->name_content = '<h2 class="tit-mien clearfix">'.$this->convertContent($item).'</h2>';
            $itemMax3dPro->content = count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'';
            $itemMax3dPro->save();
            $count++;
        }
        return $count;
    }
}
