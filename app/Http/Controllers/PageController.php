<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Page;
class PageController extends Controller
{
    public function view($request, $route, $link)
    {
        $page = Page::slug($link)->act()->first();
        if (!isset($page)) {
            abort(404);
        }
        $page->updateCountView();
        return view('pages.'.$page->layout_show, compact('page'));
    }
}