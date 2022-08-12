<?php
namespace App\Http\Controllers;

use App\Models\StaticalCrawl;

class StaticalCrawlController extends Controller
{	
    public function view($request, $route, $link){
        $currentItem = StaticalCrawl::slug($link)->act()->first();
        if ($currentItem == null) { abort(404); }
        $currentItem->updateCountView();
        if (request()->isMethod('post')) {
            if ($currentItem->type == 'tk_logan_category') {
                if (isset($request->StatisticForm) && isset($request->StatisticForm['provinceId'])) {
                    $itemStaticalCrawl = StaticalCrawl::where('type','tk_logan')->where('province_id',$request->StatisticForm['provinceId']?? '')->first();
                    if (isset($itemStaticalCrawl)) {
                        return redirect()->to($itemStaticalCrawl->slug);
                    }
                }
                return redirect()->to('/');
            }
        }
        $itemData = $currentItem->getItemData($request->all());
        $dataHtml = isset($itemData) ? $itemData->value:'';
        $dataHtml = str_replace('data-href="','data-href="'.url()->to('/').'/',$dataHtml);
        return view('staticals.view',compact('currentItem','dataHtml'));
    }
    public function staticalLoganProvince()
    {
        if (isset(request()->province_id) && request()->province_id == 1) {
            return redirect()->to('thong-ke-lo-gan-xo-so-mien-bac-xsmb');
        }
        $itemStaticalCrawl = StaticalCrawl::where('type','tk_logan')->where('province_id',request()->province_id ?? '')->first();
        if (isset($itemStaticalCrawl)) {
            return redirect()->to($itemStaticalCrawl->slug);
        }
        return redirect()->to('/');
    }
    public function frequencyFull()
    {
        $currentItem = StaticalCrawl::find(45);
        if ($currentItem == null) { abort(404); }
        $currentItem->updateCountView();
        $itemData = $currentItem->getItemData(request()->all());
        $dataHtml = isset($itemData) ? $itemData->value:'';
        $dataHtml = str_replace('data-href="','data-href="'.url()->to('/').'/',$dataHtml);
        $contentOnly = 1;
        return view('staticals.view',compact('currentItem','dataHtml','contentOnly'));
    }
    public function redirectByTypeAndProvinceId($type,$provinceId)
    {
        $itemStaticalCrawl = StaticalCrawl::where('type',$type)->where('province_id',$provinceId)->first();
        if (isset($itemStaticalCrawl)) {
            return redirect()->to($itemStaticalCrawl->slug);
        }
        return redirect()->to('/');
    }
    public function headAndTailRedirect()
    {
        return $this->redirectByTypeAndProvinceId('head_and_tail',request()->province_id ?? '');
    }
    public function headAndTailDacbietRedirect()
    {
        return $this->redirectByTypeAndProvinceId('head_and_tail_dac_biet',request()->province_id ?? '');
    }
    public function tkNhanhRedirect()
    {
        return $this->redirectByTypeAndProvinceId('tk_nhanh',request()->province_id ?? '');
    }
}