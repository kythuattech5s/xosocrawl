<?php
namespace App\Http\Controllers;

use App\Models\Forum;

class ForumController extends Controller
{	
    public function view($request, $route, $link){
        $currentItem = Forum::slug($link)->act()->first();
        if ($currentItem == null) { abort(404); }
        $currentItem->updateCountView();
        return view('forums.view',compact('currentItem'));
    }
}