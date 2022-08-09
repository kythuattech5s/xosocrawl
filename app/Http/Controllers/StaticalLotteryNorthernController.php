<?php
namespace App\Http\Controllers;
use App\Models\StaticalLotteryNorthern;
use Lotto\Models\LottoResultDetail;
use ModuleStatical\Gdbmb\ModuleStaticalGdbmb;
use ModuleStatical\Helpers\ModuleStaticalHelper;
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
            case 2:
                return $this->viewGdbByWeek($currentItem);
                break;
            case 3:
                return $this->viewGdbByMonth($currentItem);
                break;
            default:
                abort(404);
                break;
        }
    }
    public function viewGdb($currentItem)
    {
        $timeGdb = ModuleStaticalGdbmb::getGdbTime();
        $haiSoCuoiGdb = ModuleStaticalGdbmb::getHaiSoCuoiGdb();
        $listSameDuoiGdb = ModuleStaticalGdbmb::getStaticalData('bang1');

        $frequencyLotteryTouch = ModuleStaticalGdbmb::getStaticalData('frequency_lottery_touch');
        $arrFrequency = $frequencyLotteryTouch['arrFrequency'] ?? [];
        $arrLotteryTouch = $frequencyLotteryTouch['arrLotteryTouch'] ?? [];
        
        $loGanMb = ModuleStaticalGdbmb::getStaticalData('logan_mien_bac');
        $topLoGanMb = $loGanMb['topLoGanMb'] ?? [];
        $topLoGanDauMb = $loGanMb['topLoGanDauMb'] ?? [];
        $topLoGanDuoiMb = $loGanMb['topLoGanDuoiMb'] ?? [];

        $toDayPastYearLottoRecordCodeList = [];
        $now = now();
        $year = $now->year - 1;
        while ($year >= 2002) {
            array_push($toDayPastYearLottoRecordCodeList,$year.$now->format('m').$now->format('d'));
            $year--;
        }
        $listToDayPastYear = LottoResultDetail::whereHas('lottoRecord',function($q) use ($toDayPastYearLottoRecordCodeList) {
                                                            $q->where('lotto_category_id',1)->whereIn('fullcode',$toDayPastYearLottoRecordCodeList);
                                                        })
                                                        ->with('lottoRecord')
                                                        ->where('no_prize',0)
                                                        ->orderBy('created_at','desc')
                                                        ->get();
        return view('staticals.statical_lottery_northerns.gdb',compact('currentItem','haiSoCuoiGdb','listSameDuoiGdb','arrFrequency','arrLotteryTouch','topLoGanMb','topLoGanDauMb','topLoGanDuoiMb','listToDayPastYear','timeGdb'));
    }
    public function viewGdbByWeek($currentItem)
    {
        $timeStart = ModuleStaticalGdbmb::getGdbTime()->addDays(2)->subMonth(1)->startOfDay();
        $timeEnd = ModuleStaticalGdbmb::getGdbTime()->addDays(1)->endOfDay();
        $listItems = LottoResultDetail::select('created_at','number')
                                        ->where('no_prize',0)
                                        ->where('created_at','>=',$timeStart)
                                        ->where('created_at','<=',$timeEnd)
                                        ->get();
        $arrItems = [];
        foreach ($listItems as $key => $item) {
            $arrItems[ModuleStaticalHelper::timeToFullcode($item->created_at)] = $item;
        }
        return view('staticals.statical_lottery_northerns.gdb_by_week',compact('currentItem','arrItems','timeStart','timeEnd'));
    }
    public function viewGdbByMonth($currentItem)
    {
        $result = LottoResultDetail::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
                                ->where('month',8)
                                ->orderBy('year', 'desc')
                                ->get();
        return view('staticals.statical_lottery_northerns.gdb_by_month',compact('currentItem','listItems'));
    }
}