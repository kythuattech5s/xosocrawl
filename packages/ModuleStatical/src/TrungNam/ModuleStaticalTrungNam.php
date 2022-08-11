<?php
namespace ModuleStatical\TrungNam;

use Lotto\Models\LottoItem;

class ModuleStaticalTrungNam
{
    public static function getTime($lottoItemId){
        $lottoItem = LottoItem::find($lottoItemId);
        if ($lottoItem->lotto_category_id == 3) {
            $time = now()->subDays(1);
            if (now()->hour = 16 && now()->minute >= 40) {
                $time = now();
            }
            if (now()->hour > 16) {
                $time = now();
            }
            return $time;
        }
        if ($lottoItem->lotto_category_id == 4) {
            $time = now()->subDays(1);
            if (now()->hour = 17 && now()->minute >= 40) {
                $time = now();
            }
            if (now()->hour > 17) {
                $time = now();
            }
            return $time;
        }
        return now();
    }
}