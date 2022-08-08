<?php
namespace App\Http\Controllers;
use App\Models\StaticalLotteryNorthern;
use Lotto\Models\LottoRecord;
use Lotto\Models\LottoResultDetail;
use Cache;
class StaticalLotteryNorthernController extends Controller
{	
    public function view($request, $route, $link){
        $currentItem = StaticalLotteryNorthern::slug($link)->act()->first();
        if ($currentItem == null) { abort(404); }
        $currentItem->updateCountView();
        switch ($currentItem->id) {
            case 1:
                return $this->viewGdb($currentItem);
                break;
            default:
                abort(404);
                break;
        }
    }
    public function viewGdb($currentItem)
    {
        $lottoRecord = LottoRecord::orderBy('created_at','desc')->first();
        if (!isset($lottoRecord)) {
            abort(404);
        }
        $lottoGdb = $lottoRecord->lottoResultDetails()->where('no_prize',0)->first();
        if (!isset($lottoGdb)) {
            abort(404);
        }
        $haiSoCuoiGdb = substr($lottoGdb->number,-2);
        list($listSameDuoiGdb,$arrFrequency) = Cache::rememberForever('listSameDuoiGdb'.now()->day.now()->month.now()->year, function () use ($haiSoCuoiGdb) {
            $listSameDuoiGdb = LottoResultDetail::select('*',\DB::raw('RIGHT(number, 2) as duoigdb'))
                                            ->with('lottoRecord')
                                            ->where('no_prize',0)
                                            ->orderBy('created_at','desc')
                                            ->having('duoigdb',$haiSoCuoiGdb)
                                            ->limit(20)
                                            ->get();
            foreach ($listSameDuoiGdb as $item) {
                if (isset($item->lottoRecord)) {
                    $time = now()->createFromFormat('Y-m-d',substr($item->lottoRecord->fullcode,0,4).'-'.substr($item->lottoRecord->fullcode,4,2).'-'.substr($item->lottoRecord->fullcode,6,2));
                    $nextTime = $time->addDays(1);
                    $nextLottoRecord = LottoRecord::where('fullcode',$nextTime->format('Y').$nextTime->format('m').$nextTime->format('d'))->first();
                    if (isset($nextLottoRecord)) {
                        $item->nextResult = $nextLottoRecord->lottoResultDetails()->where('no_prize',0)->first();
                    }
                }
            }
            

            $allSameDuoiGdb = LottoResultDetail::select('*',\DB::raw('RIGHT(number, 2) as duoigdb'))
                                            ->with('lottoRecord')
                                            ->where('no_prize',0)
                                            ->having('duoigdb',$haiSoCuoiGdb)
                                            ->get();
            $arrCode = [];
            foreach ($allSameDuoiGdb as $key => $item) {
                $time = now()->createFromFormat('Y-m-d',substr($item->lottoRecord->fullcode,0,4).'-'.substr($item->lottoRecord->fullcode,4,2).'-'.substr($item->lottoRecord->fullcode,6,2));
                $nextTime = $time->addDays(1);
                array_push($arrCode,$nextTime->format('Y').$nextTime->format('m').$nextTime->format('d'));
            }
            $allSameDuoiGdbNext = LottoResultDetail::select('lotto_record_id','number',\DB::raw('RIGHT(number, 2) as duoigdb'))
                                                    ->whereHas('lottoRecord',function($q) use ($arrCode) {
                                                        $q->whereIn('fullcode',$arrCode);
                                                    })
                                                    ->where('no_prize',0)
                                                    ->get();
            $arrFrequency = [];
            foreach ($allSameDuoiGdbNext as $key => $item) {
                if (trim($item->duoigdb) != '') {
                    if (isset($arrFrequency[$item->duoigdb])) {
                        $arrFrequency[$item->duoigdb] = $arrFrequency[$item->duoigdb] + 1;
                    }else{
                        $arrFrequency[$item->duoigdb] = 1;
                    }
                }
            }
            return [$listSameDuoiGdb,$arrFrequency];
        });
        
        return view('staticals.statical_lottery_northerns.gdb',compact('currentItem','haiSoCuoiGdb','listSameDuoiGdb','arrFrequency'));
    }
}