<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{News};
use Support;
class NewsController extends Controller
{	
    public function view($request, $route, $link){
        $currentItem = News::slug($link)->act()->first();
        if ($currentItem == null) { abort(404); }
        $parent = $currentItem->category()->first();
        $parent = isset($parent) && \Support::show($parent,'parent') == 0?$parent:NewsCategory::act()->where('parent',\Support::show($parent,'parent'))->first();
        $newsRelateds = $currentItem->getRelatesCollection();
        $tags = $currentItem->tags;
        Support::updateCountViewed($currentItem);
        return view('news.view',compact('currentItem','newsRelateds','parent','tags'));
    }
}
