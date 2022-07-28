<?php
namespace crawlmodule\basecrawler\Crawlers;
use App\Models\Menu;
class MenuCrawler extends BaseCrawler
{
    protected $linkCrawlMenu = "https://xoso.me/";
    public function startCrawl()
    {
        Menu::truncate();
        $html = $this->exeCurl($this->linkCrawlMenu);
        $htmlDom = str_get_html($html);
        $listCrawlMenuPcLv1 = $htmlDom->find('#nav .main li.fl');
        foreach ($listCrawlMenuPcLv1 as $key => $itemCrawlMenuPcLv1) {
            $mainLinks = $itemCrawlMenuPcLv1->find('a.fl');
            if (count($mainLinks) == 0) {
                continue;
            }
            $mainLink = $mainLinks[0];
            $menuPcLv1 = new Menu;
            $menuPcLv1->name = $mainLink->innertext;
            $menuPcLv1->link = $this->clearLink($mainLink->href);
            $menuPcLv1->act = 1;
            $menuPcLv1->ord = $key + 1;
            $menuPcLv1->menu_category_id = 1;
            $menuPcLv1->parent = 0;
            $menuPcLv1->save();

            $listCrawlMenuPcLv2 = $itemCrawlMenuPcLv1->find('ul a');
            foreach ($listCrawlMenuPcLv2 as $key2 => $itemCrawlMenuPcLv2) {
                $menuPcLv2 = new Menu;
                $menuPcLv2->name = $itemCrawlMenuPcLv2->plaintext;
                $menuPcLv2->link = $this->clearLink($itemCrawlMenuPcLv2->href);
                $menuPcLv2->act = 1;
                $menuPcLv2->ord = $key2 + 1;
                $menuPcLv2->menu_category_id = 1;
                $menuPcLv2->parent = $menuPcLv1->id;
                $menuPcLv2->save();
            }
        }
        $listCrawlMenuMobile = $htmlDom->find('#nav .nav-mobi a');
        foreach ($listCrawlMenuMobile as $key => $itemCrawlMenuPcMobile) {
            $menuMobile = new Menu;
            $menuMobile->name = $itemCrawlMenuPcMobile->innertext;
            $menuMobile->link = $this->clearLink($itemCrawlMenuPcMobile->href);
            $menuMobile->act = 1;
            $menuMobile->ord = $key + 1;
            $menuMobile->menu_category_id = 2;
            $menuMobile->parent = 0;
            $menuMobile->save();
        }
        return true;
    }
}
