<?php
namespace crawlmodule\basecrawler\Crawlers;

use App\Models\KenoVietlott;

class KenoCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/keno';
    protected $crawlLink = 'https://xoso.me/xs-keno-vietlott-xo-so-tu-chon-keno-vietlott-hom-nay.html';
    public function startCrawl()
    {
        set_time_limit(-1);
        $html = $this->exeCurl($this->crawlLink);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;

        $listItems = $htmlDom->find('.keno .results .box');
        $countItemAdd = $this->crawlItems($listItems,$htmlDom);
        $nextLink = $htmlDom->find('.paging.txt-center.magb10 a.active')[0]->next_sibling();
        while (isset($nextLink) && $countItemAdd > 0) {
            $html = $this->exeCurl($nextLink->href);
            $htmlDom = str_get_html($html);
            if (!$htmlDom) return false;
            $listItems = $htmlDom->find('.keno .results .box');
            $countItemAdd = $this->crawlItems($listItems,$htmlDom);
            $nextLink = $htmlDom->find('.paging.txt-center.magb10 a.active')[0]->next_sibling();
        }
        return true;
    }
    public function crawlItems($listItems,$baseDom)
    {
        $count = 0;
        foreach ($listItems as $key => $item) {
            $itemKeno = new KenoVietlott;
            $itemTitles = $item->find('.tit-mien.clearfix.kq-title');
            $itemContents = $item->find('div');
            $kiQuay = count($itemTitles) > 0 ? $itemTitles[0]->find('span.clnote'):null;
            $listNumber = $item->find('table.data i');
            $strNumber = '';
            foreach ($listNumber as $itemNumber) {
                $strNumber .= $itemNumber->plaintext.',';
            }
            if (isset($kiQuay)) {
                $itemKeno->time_spin = count($kiQuay) > 0 ? $kiQuay[0]->plaintext:'';
            }
            $itemKeno->name = trim(str_replace('  ',' ',strip_tags(trim(count($itemTitles) > 0 ? $itemTitles[0]->plaintext:''))));
            $id = count($itemContents) > 0 ? $itemContents[0]->id:'';
            preg_match('/(\d{1,2})-(\d{1,2})-(\d{4})/', str_replace('/','-',$itemKeno->name), $dates);
            if (count($dates) == 4) {
                $day = $dates[1];
                $month = $dates[2];
                $year = $dates[3];
                $code = $dates[3].$dates[2].$dates[1];
                $time = now()->createFromFormat('d/m/Y H:i:s',$day.'/'.$month.'/'.$year.' 18:30:00');
                $fullCode = $year.$month.$day;
                $itemKeno->code = $code;
                $itemKeno->time = $time->timestamp;
                $itemKeno->fullCode = $fullCode;
                $itemKeno->created_at = $time;
                $itemKeno->updated_at = $time;
            }
            $oldItem = KenoVietlott::where('fullcode',$itemKeno->fullCode)
                                    ->where('time_spin',$itemKeno->time_spin)
                                    ->first();
            if (isset($oldItem)) {
                continue;
            }
            $itemKeno->act = 1;
            $itemKeno->name_content = '<h2 class="tit-mien clearfix kq-title">'.(count($itemTitles) > 0 ? $this->convertContent($itemTitles[0]):'').'</h2>';
            $itemKeno->content = '<div id="'.$id.'">'.(count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'').'</div>';
            $itemKeno->content = str_replace($id,'load_kq_keno',$itemKeno->content);
            $itemKeno->list_number = trim($strNumber,',');
            $itemKeno->save();
            $count++;
        }
        return $count;
    }
}
