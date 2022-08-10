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
            case 4:
                return $this->viewGdbByYear($currentItem);
                break;
            case 5:
                return $this->viewGdbByTotal($currentItem);
                break;
            default:
                abort(404);
                break;
        }
    }
    public function viewGdb($currentItem)
    {
        $gdbTime = ModuleStaticalGdbmb::getGdbTime();
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
        $year = $gdbTime->year - 1;
        while ($year >= 2002) {
            array_push($toDayPastYearLottoRecordCodeList,$year.$gdbTime->format('m').$gdbTime->format('d'));
            $year--;
        }
        $listToDayPastYear = LottoResultDetail::whereHas('lottoRecord',function($q) use ($toDayPastYearLottoRecordCodeList) {
                                                            $q->where('lotto_category_id',1)->whereIn('fullcode',$toDayPastYearLottoRecordCodeList);
                                                        })
                                                        ->with('lottoRecord')
                                                        ->where('no_prize',0)
                                                        ->orderBy('created_at','desc')
                                                        ->get();
        return view('staticals.statical_lottery_northerns.gdb',compact('currentItem','haiSoCuoiGdb','listSameDuoiGdb','arrFrequency','arrLotteryTouch','topLoGanMb','topLoGanDauMb','topLoGanDuoiMb','listToDayPastYear'));
    }
    public function viewGdbByWeek($currentItem)
    {
        $timeStart = ModuleStaticalGdbmb::getGdbTime()->addDays(2)->subMonth(1)->startOfDay();
        $timeEnd = ModuleStaticalGdbmb::getGdbTime()->addDays(1)->endOfDay();
        $listItems = LottoResultDetail::select('created_at','number')
                                        ->whereHas('lottoRecord',function($q) {
                                            $q->where('lotto_category_id',1);
                                        })
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
        $activeMonth = request()->month ?? now()->month;
        $listItems = LottoResultDetail::select('number','created_at')->selectRaw('month(created_at) month')
                                ->whereHas('lottoRecord',function($q) {
                                    $q->where('lotto_category_id',1);
                                })
                                ->where('no_prize',0)
                                ->having('month',$activeMonth)
                                ->orderBy('created_at', 'desc')
                                ->get();
        $arrItems = [];
        foreach ($listItems as $item) {
            $arrItems[ModuleStaticalHelper::timeToFullcode($item->created_at)] = $item;
        }
        return view('staticals.statical_lottery_northerns.gdb_by_month',compact('currentItem','arrItems','activeMonth'));
    }
    public function viewGdbByYear($currentItem)
    {
        $activeYear = request()->year ?? now()->year;
        $listItems = LottoResultDetail::select('number','created_at')->selectRaw('year(created_at) year')
                                ->whereHas('lottoRecord',function($q) {
                                    $q->where('lotto_category_id',1);
                                })
                                ->where('no_prize',0)
                                ->having('year',$activeYear)
                                ->orderBy('created_at', 'desc')
                                ->get();
        $arrItems = [];
        foreach ($listItems as $item) {
            $arrItems[ModuleStaticalHelper::timeToFullcode($item->created_at)] = $item;
        }
        return view('staticals.statical_lottery_northerns.gdb_by_year',compact('currentItem','arrItems','activeYear'));
    }
    public function viewGdbByTotal($currentItem)
    {
        $valueValidate = true;
        $valueValidateMessage = '';
        $startDate = now();
        $endDate = now();
        if (isset(request()->from_date)) {
            try {
                $time = request()->from_date;
                $infoTime   = explode(' - ',$time);
                $startDate 	= now()->createFromFormat('d-m-Y',$infoTime[0]);
                $endDate 	= now()->createFromFormat('d-m-Y',$infoTime[1]);
                if ($endDate->diff($startDate)->days > 765) {
                    $valueValidate = false;
                    $valueValidateMessage = 'Dữ liệu không hợp lệ: Khoảng ngày tối đa là 2 năm.';
                }
            } catch (\Throwable $th) {
                $valueValidate = false;
                $valueValidateMessage = 'Dữ liệu không hợp lệ: Sai định dạng ngày tháng.';
            }
        }else{
            $startDate = now()->subDays(100);
            $endDate = now();
        }
        $fromDateValue = isset(request()->from_date) ? request()->from_date:$startDate->format('d-m-Y').' - '.$endDate->format('d-m-Y');
        $arrItems = [];
        if ($valueValidate) {
            $listItems = LottoResultDetail::select('created_at','number')
                        ->whereHas('lottoRecord',function($q) {
                            $q->where('lotto_category_id',1);
                        })
                        ->where('no_prize',0)
                        ->where('created_at','>=',$startDate)
                        ->where('created_at','<=',$endDate)
                        ->get();
            foreach ($listItems as $key => $item) {
                $arrItems[ModuleStaticalHelper::timeToFullcode($item->created_at)] = $item;
            }
        }
        return view('staticals.statical_lottery_northerns.gdb_by_total',compact('currentItem','valueValidate','valueValidateMessage','fromDateValue','arrItems','startDate','endDate'));
    }
}