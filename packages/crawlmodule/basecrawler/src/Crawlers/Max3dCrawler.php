<?php
namespace crawlmodule\basecrawler\Crawlers;

use App\Models\Max3dVietlott;

class Max3dCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/max3d';
    protected $crawlLink = 'https://xoso.me/kqxs-max3d-ket-qua-xo-so-max-3d-vietlott.html';
    public function startCrawl()
    {
        set_time_limit(-1);
        $html = $this->exeCurl($this->crawlLink);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;

        $listItems = $htmlDom->find('.tit-mien.clearfix');
        $countItemAdd = $this->crawlItems($listItems,$htmlDom);
        $nextLink = $htmlDom->find('.loading-page a.primary');
        while (count($nextLink) > 0 && $countItemAdd) {
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
            $itemContents = $baseDom->find('#load_kq_3d_'.$key);
            $itemMax3d = new Max3dVietlott;
            $itemMax3d->name = trim($item->plaintext);
            preg_match('/(\d{1,2})-(\d{1,2})-(\d{4})/', $itemMax3d->name, $dates);
            if (count($dates) == 4) {
                $day = $dates[1] < 10 ? '0'.$dates[1]:$dates[1];
                $month = $dates[2] < 10 ? '0'.$dates[2]:$dates[2];
                $year = $dates[3];
                $code = $dates[3].$dates[2].$dates[1];
                $time = now()->createFromFormat('d/m/Y H:i:s',$day.'/'.$month.'/'.$year.' 18:30:00');
                $fullCode = $year.$month.$day;
                $itemMax3d->code = $code;
                $itemMax3d->time = $time->timestamp;
                $itemMax3d->fullCode = $fullCode;
                $itemMax3d->created_at = $time;
                $itemMax3d->updated_at = $time;
            }
            $oldItem = Max3dVietlott::where('fullcode',$itemMax3d->fullCode)->first();
            if (isset($oldItem)) {
                continue;
            }
            $itemMax3d->act = 1;
            $itemMax3d->name_content = '<h2 class="tit-mien clearfix">'.$this->convertContent($item).'</h2>';
            $itemMax3d->content = count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'';
            $itemMax3d->save();
            $count++;
        }
        return $count;
    }
}
