<?php
namespace crawlmodule\basecrawler\Crawlers;

use App\Models\Page;

class TestSpinVietlottCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/test-spin-viettlot';
    protected $crawlLink = 'https://xoso.me/quay-thu-vietlott-mega-645-power-655-max4d-ngay-hom-nay.html';
    public function startCrawl()
    {
        set_time_limit(-1);
        $html = $this->exeCurl($this->crawlLink);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;
        $contentMega645s = $htmlDom->find('.mega645');
        $contentMega645Power655s = $htmlDom->find('.mega645.power655');
        $contentMega645 = count($contentMega645s) > 0 ? $this->convertContent($contentMega645s[0]):'';
        $contentMega645Power655 = count($contentMega645Power655s) > 0 ? $this->convertContent($contentMega645Power655s[0]):'';
        $contentTotal = '<div class="mega645">'.$contentMega645.'</div><div class="mega645 power655">'.$contentMega645Power655.'</div>';
        $pages = Page::where('layout_show','spin_test_vietlott')->get();
        foreach ($pages as $itemPage) {
            $itemPage->moreinfo = $contentTotal;
            $itemPage->save();
        }
        return true;
    }
}
