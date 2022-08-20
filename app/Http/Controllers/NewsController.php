<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{News};
use Support;
class NewsController extends Controller
{	
    public function view($request, $route, $link){
        $currentItem = News::slug($link)->act()->first();
        if ($currentItem == null) {
            try {
                $newCrawler = new \crawlmodule\basecrawler\Crawlers\NewsCrawler;
                $newCrawler->crawlItem(vsprintf('https://xoso.me/tin-tuc/%s.html',[$link]));
                $currentItem = News::slug($link)->act()->first();
                if (!$currentItem) {
                    abort(404);
                }
            } catch (\Throwable $th) {
                abort(404);
            }
        }
        $currentItem->updateCountView();
        return view('news.view',compact('currentItem'));
    }
    public function _view($link)
    {
        return redirect($link,301);
    }
}
