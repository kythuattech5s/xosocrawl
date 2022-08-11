<?php
namespace ModuleStatical\TrungNam;

class ModuleStaticalLoganTrungNam extends ModuleStaticalTrungNam
{
    public static function getTopGanByLoganItem($itemLogan,$minGan,$limit = null)
    {
        $currentTime = self::getTime($itemLogan->lotto_item_id);
        $arrDayOfWeek = explode(',',$itemLogan->day_of_week);
        $listDuoi = \DB::select(vsprintf("select *,DATEDIFF('%s',max_time)/7*%s as gan from (select right(number, 2) as duoi, max(created_at) as max_time from `lotto_result_details` where `lotto_item_id` = %s group by `duoi` having `duoi` != '') as base having gan > %s ORDER BY gan desc,duoi asc%s",[$currentTime->format('Y-m-d H:i:s'),count($arrDayOfWeek),$itemLogan->lotto_item_id,$minGan,isset($limit) ? ' limit '.$limit:'']));

        $arrItemDuoi = [];
        foreach ($listDuoi as $itemDuoi) {
            array_push($arrItemDuoi,$itemDuoi->duoi);
        }

        $listGanCucDai = \DB::select(vsprintf("select duoi,max(max_gan) as gan_maximum from (select *,DATEDIFF(previous_time,created_at)/7*%s as max_gan from(SELECT right(number, 2) as duoi,created_at,lag(created_at) OVER (PARTITION BY duoi ORDER BY created_at desc) AS previous_time from `lotto_result_details` where `lotto_item_id` = %s having duoi in('%s')) as base) as base GROUP BY duoi",[count($arrDayOfWeek),$itemLogan->lotto_item_id,implode("','",$arrItemDuoi)]));

        $arrGanCucDai = [];
        foreach ($listGanCucDai as $itemGanCucDai) {
            $arrGanCucDai[$itemGanCucDai->duoi] = (int)$itemGanCucDai->gan_maximum - 1;
        }
        foreach ($listDuoi as $item) {
            $item->gan = (int)$item->gan;
            $item->gan_maximum = 0;
            if (isset($arrGanCucDai[$item->duoi])) {
                $item->gan_maximum = $item->gan > $arrGanCucDai[$item->duoi] ? $item->gan:$arrGanCucDai[$item->duoi];
            }
        }
        return $listDuoi;
    }
    public function getTopCapLogan($itemLogan)
    {
        $currentTime = self::getTime($itemLogan->lotto_item_id);
        $arrDayOfWeek = explode(',',$itemLogan->day_of_week);
        $arrDuoiCap = [];
        for ($i=0; $i <= 9; $i++) { 
            for ($j=0; $j <= 9; $j++) { 
                if ($i.$j != $j.$i) {
                    array_push($arrDuoiCap,$i.$j);
                }
            }
        }
        $listDuoi = \DB::select(vsprintf("select *,DATEDIFF('%s',max_time)/7*%s as gan from (select right(number, 2) as duoi, max(created_at) as max_time from `lotto_result_details` where `lotto_item_id` = %s group by `duoi` having `duoi` in ('%s')) as base order by gan desc",[$currentTime->format('Y-m-d H:i:s'),count($arrDayOfWeek),$itemLogan->lotto_item_id,implode("','",$arrDuoiCap)]));
        $arrDuoiGan = [];
        foreach ($listDuoi as $item) {
            $arrDuoiGan[$item->duoi]['gan'] = (int)$item->gan;
            $arrDuoiGan[$item->duoi]['max_time'] = $item->max_time;
        }
        $ret = [];
        
        for ($i=0; $i <= 9; $i++) { 
            for ($j=0; $j <= 9; $j++) { 
                if ($i.$j != $j.$i) {
                    if (!isset($ret[$i.$j.'-'.$j.$i]) && !isset($ret[$j.$i.'-'.$i.$j])) {
                        $ret[$i.$j.'-'.$j.$i]['gan'] = $arrDuoiGan[$i.$j] > $arrDuoiGan[$j.$i] ? $arrDuoiGan[$j.$i]['gan']:$arrDuoiGan[$i.$j]['gan'];
                        $ret[$i.$j.'-'.$j.$i]['max_time'] = $arrDuoiGan[$i.$j] > $arrDuoiGan[$j.$i] ? $arrDuoiGan[$j.$i]['max_time']:$arrDuoiGan[$i.$j]['max_time'];
                    }
                }
            }
        }

        arsort($ret);
        $ret = array_splice($ret,0,10);
        $strDuoiTinhCucDai = "'";
        foreach ($ret as $key => $item) {
            $strDuoiTinhCucDai.= str_replace("-","','",$key)."','";
        }
        $strDuoiTinhCucDai = trim($strDuoiTinhCucDai,",'");
        $listGanCucDai = \DB::select(vsprintf("select duoi,max(max_gan) as gan_maximum from (select *,DATEDIFF(previous_time,created_at)/7*%s as max_gan from(SELECT right(number, 2) as duoi,created_at,lag(created_at) OVER (PARTITION BY duoi ORDER BY created_at desc) AS previous_time from `lotto_result_details` where `lotto_item_id` = %s having duoi in('%s')) as base) as base GROUP BY duoi",[count($arrDayOfWeek),$itemLogan->lotto_item_id,$strDuoiTinhCucDai]));
        dd($listGanCucDai);
        return array_splice($ret,0,10);
    }
}