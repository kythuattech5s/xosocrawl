<?php
namespace ModuleStatical\Gdbmb;

use Lotto\Models\LottoRecord;
use Lotto\Models\LottoResultDetail;
use ModuleStatical\Models\StaticalGdbmb;
use ModuleStatical\Helpers\ModuleStaticalHelper;

class ModuleStaticalGdbmb
{
    public static function createStaticalData($type)
    {
        switch ($type) {
            case 'bang1':
                return self::createStaticalDataBang1($type);
                break;
            case 'frequency_lottery_touch':
                return self::createStaticalDataFrequencyLotteryTouch($type);
                break;
            case 'logan_mien_bac':
                return self::createStaticalDataLoganMienBac($type);
                break;
            default:
                return false;
                break;
        }
    }
    public static function getStaticalData($type,$key = null)
    {
        $time = self::getGdbTime();
        $oldItem = StaticalGdbmb::getItemData($type,$time,$key);
        if (!isset($oldItem)){
            self::createStaticalData($type);
        }else{
            return ModuleStaticalHelper::extractJson($oldItem->value);
        }
        $oldItem = StaticalGdbmb::getItemData($type,$time,$key);
        if (!isset($oldItem)){
            return [];
        }
        return ModuleStaticalHelper::extractJson($oldItem->value);
    }
    public static function getGdbTime(){
        $time = now()->subDays(1);
        if (now()->hour >= 18 && now()->minute >= 18) {
            $time = now();
        }
        return $time;
    }
    public static function getHaiSoCuoiGdb(){
        $time = self::getGdbTime();
        $fullcode = ModuleStaticalHelper::timeToFullcode($time);
        $lottoRecord = LottoRecord::where('lotto_category_id',1)->where('fullcode',$fullcode)->first();
        if (!isset($lottoRecord)) return '';
        $lottoGdb = $lottoRecord->lottoResultDetails()->where('no_prize',0)->first();
        if (!isset($lottoGdb)) return '';
        $haiSoCuoiGdb = substr($lottoGdb->number,-2);
        return $haiSoCuoiGdb;
    }
    public static function createStaticalDataBang1($type)
    {
        $time = self::getGdbTime();
        if (!StaticalGdbmb::checkExist($type,$time)) {
            $haiSoCuoiGdb = self::getHaiSoCuoiGdb();
            $listSameDuoiGdb = LottoResultDetail::select('*',\DB::raw('RIGHT(number, 2) as duoigdb'))
                                        ->whereHas('lottoRecord',function($q){
                                            $q->where('lotto_category_id',1);
                                        })
                                        ->with('lottoRecord')
                                        ->where('no_prize',0)
                                        ->orderBy('created_at','desc')
                                        ->having('duoigdb',$haiSoCuoiGdb)
                                        ->limit(20)
                                        ->get();
            foreach ($listSameDuoiGdb as $item) {
                if (isset($item->lottoRecord)) {
                    $nextTime = $item->lottoRecord->created_at->addDays(1);
                    $nextLottoRecord = LottoRecord::where('lotto_category_id',1)->where('fullcode',ModuleStaticalHelper::timeToFullcode($nextTime))->first();
                    if (isset($nextLottoRecord)) {
                        $nextResult = $nextLottoRecord->lottoResultDetails()
                                                            ->with('lottoRecord')
                                                            ->where('no_prize',0)
                                                            ->first();
                        if (isset($nextResult)) {
                            $item->nextResult = $nextResult->toArray();
                        }
                    }
                }
            }
            $staticalGdbmb = new StaticalGdbmb;
            $staticalGdbmb->day = $time->day;
            $staticalGdbmb->month = $time->month;
            $staticalGdbmb->year = $time->year;
            $staticalGdbmb->type = $type;
            $staticalGdbmb->value = json_encode($listSameDuoiGdb->toArray());
            $staticalGdbmb->save();
        }
    }
    public static function createStaticalDataFrequencyLotteryTouch($type)
    {
        $time = self::getGdbTime();
        if (!StaticalGdbmb::checkExist($type,$time)) {
            $haiSoCuoiGdb = self::getHaiSoCuoiGdb();
            $allSameDuoiGdb = LottoResultDetail::select('*',\DB::raw('RIGHT(number, 2) as duoigdb'))
                                            ->whereHas('lottoRecord',function($q){
                                                $q->where('lotto_category_id',1);
                                            })
                                            ->with('lottoRecord')
                                            ->where('no_prize',0)
                                            ->having('duoigdb',$haiSoCuoiGdb)
                                            ->get();
            $arrCode = [];
            foreach ($allSameDuoiGdb as $key => $item) {
                $nextTime = $item->lottoRecord->created_at->addDays(1);
                array_push($arrCode,ModuleStaticalHelper::timeToFullcode($nextTime));
            }
            $allSameDuoiGdbNext = LottoResultDetail::select('lotto_record_id','number',\DB::raw('RIGHT(number, 2) as duoigdb'))
                                                    ->whereHas('lottoRecord',function($q) use ($arrCode) {
                                                        $q->whereIn('fullcode',$arrCode)->where('lotto_category_id',1);
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
            $arrLotteryTouch = [];
            $arrLotteryTouch['dau'] = [];
            $arrLotteryTouch['duoi'] = [];
            $arrLotteryTouch['tong'] = [];
            foreach ($arrFrequency as $key => $item) {
                if (isset($arrLotteryTouch['dau'][substr($key,0,1)])) {
                    $arrLotteryTouch['dau'][substr($key,0,1)] = $arrLotteryTouch['dau'][substr($key,0,1)] + $item;
                }else{
                    $arrLotteryTouch['dau'][substr($key,0,1)] = $item;
                }
                if (isset($arrLotteryTouch['duoi'][substr($key,1,1)])) {
                    $arrLotteryTouch['duoi'][substr($key,1,1)] = $arrLotteryTouch['duoi'][substr($key,1,1)] + $item;
                }else{
                    $arrLotteryTouch['duoi'][substr($key,1,1)] = $item;
                }
                $tong = ((int)substr($key,0,1) + (int)substr($key,1,1))%10;
                if (isset($arrLotteryTouch['tong'][$tong])) {
                    $arrLotteryTouch['tong'][$tong] = $arrLotteryTouch['tong'][$tong] + $item;
                }else{
                    $arrLotteryTouch['tong'][$tong] = $item;
                }
            }

            $data = [];
            $data['arrFrequency'] = $arrFrequency;
            $data['arrLotteryTouch'] = $arrLotteryTouch;
            $staticalGdbmb = new StaticalGdbmb;
            $staticalGdbmb->day = $time->day;
            $staticalGdbmb->month = $time->month;
            $staticalGdbmb->year = $time->year;
            $staticalGdbmb->type = $type;
            $staticalGdbmb->key = $haiSoCuoiGdb;
            $staticalGdbmb->value = json_encode($data);
            $staticalGdbmb->save();
        }
    }
    public static function createStaticalDataLoganMienBac($type)
    {
        $time = self::getGdbTime();
        if (!StaticalGdbmb::checkExist($type,$time)) {
            $topLoGanMb = LottoResultDetail::select(\DB::raw('right(lotto_result_details.number, 2) as duoigdb'),\DB::raw('max(lotto_records.created_at) as max_time'))
                                            ->join('lotto_records', 'lotto_result_details.lotto_record_id', '=', 'lotto_records.id')
                                            ->whereHas('lottoRecord',function($q) {
                                                $q->where('lotto_category_id',1);
                                            })
                                            ->where('lotto_result_details.no_prize',0)
                                            ->groupBy('duoigdb')
                                            ->having('duoigdb','!=','')
                                            ->orderBy('max_time','asc')
                                            ->limit(10)
                                            ->get();
            $topLoGanDauMb = LottoResultDetail::select(\DB::raw('left(right(lotto_result_details.number, 2),1) as dau'),\DB::raw('max(lotto_records.created_at) as max_time'))
                                            ->join('lotto_records', 'lotto_result_details.lotto_record_id', '=', 'lotto_records.id')
                                            ->whereHas('lottoRecord',function($q) {
                                                $q->where('lotto_category_id',1);
                                            })
                                            ->where('lotto_result_details.no_prize',0)
                                            ->groupBy('dau')
                                            ->having('dau','!=','')
                                            ->orderBy('max_time','asc')
                                            ->limit(10)
                                            ->get();
            $topLoGanDuoiMb = LottoResultDetail::select(\DB::raw('right(lotto_result_details.number, 1) as duoi'),\DB::raw('max(lotto_records.created_at) as max_time'))
                                            ->join('lotto_records', 'lotto_result_details.lotto_record_id', '=', 'lotto_records.id')
                                            ->whereHas('lottoRecord',function($q) {
                                                $q->where('lotto_category_id',1);
                                            })
                                            ->where('lotto_result_details.no_prize',0)
                                            ->groupBy('duoi')
                                            ->having('duoi','!=','')
                                            ->orderBy('max_time','asc')
                                            ->limit(10)
                                            ->get();
            $data = [];
            $data['topLoGanMb'] = $topLoGanMb->toArray();
            $data['topLoGanDauMb'] = $topLoGanDauMb->toArray();
            $data['topLoGanDuoiMb'] = $topLoGanDuoiMb->toArray();
            $staticalGdbmb = new StaticalGdbmb;
            $staticalGdbmb->day = $time->day;
            $staticalGdbmb->month = $time->month;
            $staticalGdbmb->year = $time->year;
            $staticalGdbmb->type = $type;
            $staticalGdbmb->value = json_encode($data);
            $staticalGdbmb->save();
        }
    }
}