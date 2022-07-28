<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Page;
class PageController extends Controller
{
    public function view($request, $route, $link)
    {
        $currentItem = Page::slug($link)->act()->first();
        if (!isset($currentItem)) {
            abort(404);
        }
        $currentItem->updateCountView();
        return view('pages.'.$currentItem->layout_show, compact('currentItem'));
    }
}