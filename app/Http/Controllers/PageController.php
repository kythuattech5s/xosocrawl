<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\DreamNumberDecoding;
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
        if ($currentItem->layout_show == 'dream_number_decodings') {
            return $this->viewPageAllDreamNumberDecoding($request,$currentItem);
        }
        return view('pages.'.$currentItem->layout_show, compact('currentItem'));
    }
    private function viewPageAllDreamNumberDecoding($request,$currentItem){
        $tuKhoa = $request->tukhoa ?? null;
        $listMostView = DreamNumberDecoding::where('id','!=',$currentItem->id)
                                            ->orderBy('count','desc')
                                            ->orderBy('id','desc')
                                            ->limit(10)
                                            ->get();
        $listItems = DreamNumberDecoding::when($tuKhoa,function($q) use ($tuKhoa) {
                                            $q->where(function($q) use ($tuKhoa){
                                                $q->where('name','like',$tuKhoa);
                                                $q->orWhere('key_name','like','%'.$tuKhoa.'%');
                                            });
                                        })
                                        ->act()
                                        ->orderBy('id','desc')
                                        ->paginate(20);
        return view('pages.'.$currentItem->layout_show, compact('currentItem','listItems','listMostView'));
    }
}