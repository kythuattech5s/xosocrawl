<?php
namespace ModuleStatical\TrungNam;

use Lotto\Models\LottoResultDetail;
use ModuleStatical\Helpers\ModuleStaticalHelper;

class ModuleStaticalLoganTrungNam extends ModuleStaticalTrungNam
{
    public static function getTopGanByLoganItem($itemLogan,$top)
    {
        $currentTime = self::getTime();
        $listItems = LottoResultDetail::select(\DB::raw('right(number, 2) as duoi'),\DB::raw('max(created_at) as max_time'))
                                ->where('lotto_item_id',$itemLogan->lotto_item_id)
                                ->groupBy('duoi')
                                ->having('duoi','!=','')
                                ->orderBy('max_time','asc')
                                ->limit($top)
                                ->get();
        $arrDayOfWeek = explode(',',$itemLogan->day_of_week);
        foreach ($listItems as $item) {
            $maxTime = ModuleStaticalHelper::parseStringToTime($item->max_time);
            $weekDiff = $currentTime->diffInWeeks($maxTime);
            $totalGanDay = $weekDiff > 1 ? ($weekDiff - 1)*count($arrDayOfWeek):0;

            $maxTimeDayOfWeek = $maxTime->dayOfWeek == 0 ? 7:$maxTime->dayOfWeek;
            $count = $maxTimeDayOfWeek;
            do {
                $count++;
                $compare = $count == 7 ? 0:$count;
                if (in_array($compare,$arrDayOfWeek)) {
                    $totalGanDay++;
                }
            } while ($count <= 7);

            $count = $currentTime->dayOfWeek;
            while ($count > 0) {
                $count--;
                if (in_array($count,$arrDayOfWeek)) {
                    $totalGanDay++;
                }
            }
            $item->dayGan = $totalGanDay;
        }
        $listDuoi = $listItems->pluck('duoi');
        
        return $listItems;
    }
}