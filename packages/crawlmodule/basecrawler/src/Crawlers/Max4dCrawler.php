<?php
namespace crawlmodule\basecrawler\Crawlers;

use App\Models\Max4dVietlott;

class Max4dCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/max4d';
    protected $crawlLinks = [
        'max_4d_vietlott_thu_3' => 'https://xoso.me/kqxs-max4d-thu-3-ket-qua-xo-so-max-4d-vietlott-thu-3-truc-tiep.html',
        'max_4d_vietlott_thu_5' => 'https://xoso.me/kqxs-max4d-thu-5-ket-qua-xo-so-max-4d-vietlott-thu-5-truc-tiep.html',
        'max_4d_vietlott_thu_7' => 'https://xoso.me/kqxs-max4d-thu-7-ket-qua-xo-so-max-4d-vietlott-thu-7-truc-tiep.html'
    ];
    public function startCrawl()
    {
        set_time_limit(-1);
        foreach ($this->crawlLinks as $typeMax4d => $crawlLink) {
            $html = $this->exeCurl($crawlLink);
            $htmlDom = str_get_html($html);
            if (!$htmlDom) return false;
            $listItems = $htmlDom->find('.tit-mien.clearfix');
            $countItemAdd = $this->crawlItems($listItems,$htmlDom,$typeMax4d);
            $nextLink = $htmlDom->find('.loading-page a.primary');
            while (count($nextLink) > 0 && $countItemAdd > 0) {
                $html = $this->exeCurl($nextLink[0]->href);
                $htmlDom = str_get_html($html);
                if (!$htmlDom) return false;
                $listItems = $htmlDom->find('.tit-mien.clearfix');
                $countItemAdd = $this->crawlItems($listItems,$htmlDom,$typeMax4d);
                $nextLink = $htmlDom->find('.loading-page a.primary');
            }
        }
        return true;
    }
    public function crawlItems($listItems,$baseDom,$typeMax4d)
    {
        $count = 0;
        foreach ($listItems as $key => $item) {
            $itemContents = $baseDom->find('#load_kq_4d_'.$key);
            $itemMax4d = new Max4dVietlott;
            $itemMax4d->type = $typeMax4d;
            $itemMax4d->name = trim($item->plaintext);
            preg_match('/(\d{1,2})-(\d{1,2})-(\d{4})/', $itemMax4d->name, $dates);
            if (count($dates) == 4) {
                $day = $dates[1] < 10 ? '0'.$dates[1]:$dates[1];
                $month = $dates[2] < 10 ? '0'.$dates[2]:$dates[2];
                $year = $dates[3];
                $code = $dates[3].$dates[2].$dates[1];
                $time = now()->createFromFormat('d/m/Y H:i:s',$day.'/'.$month.'/'.$year.' 18:30:00');
                $fullCode = $year.$month.$day;
                $itemMax4d->code = $code;
                $itemMax4d->time = $time->timestamp;
                $itemMax4d->fullCode = $fullCode;
                $itemMax4d->created_at = $time;
                $itemMax4d->updated_at = $time;
            }
            $oldItem = Max4dVietlott::where('fullcode',$itemMax4d->fullCode)->first();
            if (isset($oldItem)) {
                continue;
            }
            $itemMax4d->act = 1;
            $itemMax4d->name_content = '<h2 class="tit-mien clearfix">'.$this->convertContent($item).'</h2>';
            $itemMax4d->content = count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'';
            $itemMax4d->save();
            $count++;
        }
        return $count;
    }
}
