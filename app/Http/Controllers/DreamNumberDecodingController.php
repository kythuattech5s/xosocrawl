<?php
namespace App\Http\Controllers;
use App\Models\DreamNumberDecoding;
class DreamNumberDecodingController extends Controller
{	
    public function view($request, $route, $link){
        $currentItem = DreamNumberDecoding::slug($link)->act()->first();
        if ($currentItem == null) { abort(404); }
        $currentItem->updateCountView();
        $listMostView = DreamNumberDecoding::where('id','!=',$currentItem->id)
                                            ->orderBy('count','desc')
                                            ->orderBy('id','desc')
                                            ->limit(10)
                                            ->get();
        $listSuggestion = DreamNumberDecoding::where('id','!=',$currentItem->id)
                                            ->inRandomOrder()
                                            ->limit(5)
                                            ->get();
        return view('dream_number_decodings.view',compact('currentItem','listMostView','listSuggestion'));
    }
}