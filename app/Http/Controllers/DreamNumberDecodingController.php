<?php
namespace App\Http\Controllers;
use App\Models\DreamNumberDecoding;
class DreamNumberDecodingController extends Controller
{	
    public function view($request, $route, $link){
        $currentItem = DreamNumberDecoding::slug($link)->act()->first();
        if ($currentItem == null) { abort(404); }
        $currentItem->updateCountView();
        return view('dream_number_decodings.view',compact('currentItem'));
    }
}