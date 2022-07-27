<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\NewsCategory;
use App\Models\News;
use Support;
class NewsCategoryController extends Controller
{
    public function view($request, $route, $link){
    	$currentItem = NewsCategory::slug($link)->act()->first();
    	if ($currentItem == null) {
    		abort(404);
    	}
    	$listItems = $currentItem->news()->act()->ord()->paginate(6);
    	return view('news_categories.view', compact('currentItem', 'listItems'));
    }
    public function all($request, $route, $link){
        $currentItem = \vanhenry\manager\model\VRoute::find($route->id);
        $listItems = News::act()->ord()->paginate(6);
        return view('news_categories.all', compact('currentItem', 'listItems'));
    }
}