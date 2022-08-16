<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PredictLotteryResult;
use crawlmodule\basecrawler\Crawlers\BaseCrawler;
use Illuminate\Http\Request;
use Lotto\LottoServiceProvider;
use Lotto\Models\LottoCategory;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $isHome = 1;
        // dump(LottoCategory::find(1)->lottoTodayItems());
        return view('home', compact('isHome'));
    }

    public function direction(Request $request, $link)
    {
        $lang = \App::getLocale();
        $link = \FCHelper::getSegment($request, 1);
        $route = \vanhenry\manager\model\VRoute::select('*')->where($lang.'_link', $link)->first();
        if ($route == null) {
            abort(404);
        }
        $controllers = explode('@', $route->controller);
        $controller = $controllers[0];
        $method = $controllers[1];
        return (new $controller)->$method($request, $route, $link);
    }
    public function convertThuCongDuLieuCrawl()
    {
        $baseCrawler = new BaseCrawler;
        $pages = Page::where('convert_contented',0)->get();
        foreach ($pages as $page) {
            $page->content = $baseCrawler->convertContent(str_get_html($page->content));
            if ($page->seemore_box != '') {
                $page->seemore_box = $baseCrawler->convertContent(str_get_html($page->seemore_box));
            }
            $page->seo_title = $baseCrawler->clearContent($page->seo_title);
            $page->seo_key = $baseCrawler->clearContent($page->seo_key);
            $page->seo_des = $baseCrawler->clearContent($page->seo_des);
            $page->convert_contented = 1;
            $page->save();
        }
    }
}
