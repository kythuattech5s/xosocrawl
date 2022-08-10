<?php
namespace ModuleStatical\TrungNam;

use Lotto\Models\LottoResultDetail;
use ModuleStatical\Helpers\ModuleStaticalHelper;

class ModuleStaticalLoganTrungNam extends ModuleStaticalTrungNam
{
    public static function getTopGanByLoganItem($itemLogan,$top)
    {
        $currentTime = self::getTime();
        $listDuoi = LottoResultDetail::select(\DB::raw('right(number, 2) as duoi'),\DB::raw('max(created_at) as max_time'))
                                ->where('lotto_item_id',$itemLogan->lotto_item_id)
                                ->groupBy('duoi')
                                ->having('duoi','!=','')
                                ->orderBy('max_time','asc')
                                ->limit($top)
                                ->pluck('duoi')->toArray();
        $listItemStatical = LottoResultDetail::select('created_at',\DB::raw('right(number, 2) as duoi'))
                                        ->where('lotto_item_id',$itemLogan->lotto_item_id)
                                        ->havingRaw("duoi in ('".implode("','",$listDuoi)."')")
                                        ->orderBy('created_at','asc')
                                        ->get()->groupBy('duoi');
        $arrDayOfWeek = explode(',',$itemLogan->day_of_week);
        $arrItems = [];
        foreach ($listItemStatical as $key => $itemStatical) {
            if (count($itemStatical) > 0) {
                $arrFillter = [];
                foreach ($itemStatical as $item) {
                    $arrFillter[ModuleStaticalHelper::timeToFullcode($item->created_at)] = $item; 
                }
                $arrItems[$key] = [];
                $arrItems[$key]['gan'] = 0;
                $arrItems[$key]['currentItem'] = $itemStatical[0];
                $arrItems[$key]['maxGan'] = 0;
                $timeLog = $itemStatical[0]->created_at->addDays(1);
                while ($timeLog->lt($currentTime)) {
                    if (in_array($timeLog->dayOfWeek,$arrDayOfWeek)) {
                        if (isset($arrFillter[ModuleStaticalHelper::timeToFullcode($timeLog)])) {
                            $arrItems[$key]['gan'] = 0;
                            $arrItems[$key]['currentItem'] = $arrFillter[ModuleStaticalHelper::timeToFullcode($timeLog)];
                        }else{
                            $arrItems[$key]['gan'] = $arrItems[$key]['gan']+1;
                            if ($arrItems[$key]['maxGan'] < $arrItems[$key]['gan']) {
                                $arrItems[$key]['maxGan'] = $arrItems[$key]['gan'];
                            }
                        }
                    }
                    $timeLog->addDays(1);
                }
            }
        }
        $listItems = collect($arrItems)->sortByDesc('gan');
        return $listItems;
    }
}