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
        $currentItem->updateCountView();
        return view('news.view',compact('currentItem'));
    }
}
