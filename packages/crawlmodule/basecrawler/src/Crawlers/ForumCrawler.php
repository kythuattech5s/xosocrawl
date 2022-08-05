<?php
namespace crawlmodule\basecrawler\Crawlers;
use App\Models\Forum;
use vanhenry\manager\model\VRoute as ModelVRoute;

class ForumCrawler extends BaseCrawler
{
    protected $imageSaveDir = 'old/forum';
    protected $linkCrawls = [
        'https://xoso.me/dien-dan-xo-so.html',
        'https://xoso.me/dien-dan-xsmb.html',
        'https://xoso.me/dien-dan-xsmt.html',
        'https://xoso.me/dien-dan-xsmn.html',
        'https://xoso.me/thac-mac-hoi-dap-dien-dan-xo-so.html'
    ];
    public function startCrawl()
    {
        foreach ($this->linkCrawls as $key => $linkItem) {
            $this->crawItem($linkItem);
        }
        return true;
    }
    public function crawItem($linkItem)
    {
        $itemOld = Forum::where('slug',$this->clearLink($linkItem))->first();
        if (isset($itemOld)) return;
        $html = $this->exeCurl($linkItem);
        $htmlDom = str_get_html($html);
        if (!$htmlDom) return false;
        $itemNames = $htmlDom->find('h1');
        $itemTitles = $htmlDom->find('title');
        $itemMetaDescriptions = $htmlDom->find('meta[name=description]');
        $itemMetaKeywords = $htmlDom->find('meta[name=keywords]');
        $itemMetaimgs = $htmlDom->find('meta[property=og:image]');
        $itemContents = $htmlDom->find('.box.box-html');

        $itemForum = new Forum;
        $itemForum->name = count($itemNames) > 0 ? $itemNames[0]->plaintext:$this->clearLink($linkItem);
        $itemForum->slug = $this->processSlug($this->clearLink($linkItem));
        $imgSrc = count($itemMetaimgs) > 0 ? $itemMetaimgs[0]->content:'';
        if (\Str::contains($imgSrc,'http')) {
            $itemForum->img = $this->saveImg($imgSrc,$this->imageSaveDir);
        }

        $itemForum->content = count($itemContents) > 0 ? $this->convertContent($itemContents[0]):'';
        $itemForum->act = 1;
        $itemForum->count = 0;
        $itemForum->seo_title = count($itemTitles) > 0 ? $itemTitles[0]->plaintext:$itemForum->name;
        $itemForum->seo_key = count($itemMetaKeywords) > 0 ? $itemMetaKeywords[0]->content:$itemForum->name;
        $itemForum->seo_des = count($itemMetaDescriptions) > 0 ? $itemMetaDescriptions[0]->content:$itemForum->name;

        $itemForum->seo_title = $this->clearContent($itemForum->seo_title);
        $itemForum->seo_key = $this->clearContent($itemForum->seo_key);
        $itemForum->seo_des = $this->clearContent($itemForum->seo_des);

        $itemForum->save();

        $this->inserVRouter($itemForum,'App\Http\Controllers\ForumController@view');
    }
}
