<?php

namespace Lotto\Helpers;

use Lotto\Enums\DayOfWeek;
use Lotto\Models\LottoCategory;
use Lotto\Models\LottoItem;
use Lotto\Models\LottoRecord;
use Support;

class SeoHelper
{
    public static function getSeoMienBacDow(LottoCategory $lottoCategory, LottoItem $lottoItem, LottoRecord $lottoRecord)
    {
        $date = $lottoRecord->created_at;
        $dayOfWeek = DayOfWeek::fromDate($date);
        $currentItem = new \stdClass;
        $currentItem->seo_title = $currentItem->name = vsprintf(
            '%1$s %2$s - %1$s %3$s - %4$s %2$s hàng tuần',
            [$lottoCategory->short_name, $dayOfWeek->toFullString(), $dayOfWeek->toShortString(), $lottoCategory->name]
        );
        $currentItem->seo_key = vsprintf('%1$s ngày %2$s, Kết quả %3$s ngày %4$s, KQ%1$s %4$s', [$lottoCategory->short_name, Support::format($date, 'd/m/Y'), $lottoCategory->name, Support::format($date, 'j/n/Y')]);
        $currentItem->seo_des = vsprintf('%1$s %2$s - Trực tiếp kết quả %3$s ngày %2$s lúc 18h10.✅ KQ%1$s %4$s nhanh và chính xác top #1 Việt Nam, %1$s %4$s', [$lottoCategory->short_name, Support::format($date, 'd/m/Y'), $lottoCategory->name, Support::format($date, 'j/n/Y')]);
        return $currentItem;
    }
    public static function getSeoMienBacCategory(LottoCategory $lottoCategory, LottoItem $lottoItem, LottoRecord $lottoRecord)
    {
        $currentItem = new \stdClass;
        $currentItem->seo_title = $currentItem->name =
            'SXMB - XSMB - KQXSMB - Xổ Số Miền Bắc hôm nay - XSTD - XSHN - XSKTMB';;
        $currentItem->seo_des = 'SXMB - XSMB - KQXSMB - Kết quả Xổ Số Miền Bắc hôm nay lúc 18h10 - XSTD - XSHN.❤️ Xổ số kiến thiết Miền Bắc nhanh và chính xác 100%, Xổ số Hà Nội, XSKT MB, SX TD';
        $currentItem->seo_key =
            'XSMB, SXMB, XSTD, XSHN, KQXSMB, KQXS miền bắc, Xo so mien Bac, XSKTMB, Xổ số đài Bắc, SXHN, Xổ số miền Bắc, Xổ số kiến thiết miền Bắc, kqsxmb, xổ số mb, soxomienbac, ketquaxosomienbac, kqsx mb, sxtd, kqxstd, xo so mb, xsmb hn, xxmb,ssmb, Xổ số thủ đô';
        return $currentItem;
    }
    public static function getSeoMienBacDmY(LottoCategory $lottoCategory, LottoItem $lottoItem, LottoRecord $lottoRecord)
    {
        $date = $lottoRecord->created_at;
        $currentItem = new \stdClass;
        $currentItem->seo_title = $currentItem->name = vsprintf(
            '%1$s %2$s - %3$s ngày %4$s',
            [$lottoCategory->short_name, $date->format('d/m/Y'), $lottoCategory->name, $date->format('j/n/Y')]
        );
        $currentItem->seo_key = vsprintf('%1$s ngày %2$s, Kết quả %3$s ngày %4$s, KQ%1$s %4$s', [$lottoCategory->short_name, Support::format($date, 'd/m/Y'), $lottoCategory->name, Support::format($date, 'j/n/Y')]);
        $currentItem->seo_des = vsprintf(
            '%1$s %2$s - Trực tiếp kết quả %3$s ngày %2$s lúc 18h10.✅ KQ%1$s %4$s nhanh và chính xác top #1 Việt Nam, %1$s %4$s',
            [$lottoCategory->short_name, Support::format($date, 'd/m/Y'), $lottoCategory->name, Support::format($date, 'j/n/Y')]
        );
        return $currentItem;
    }
    public static function getSeoProvince(LottoItem $lottoItem, LottoRecord $lottoRecord)
    {
        $currentItem = new \stdClass;
        $dateFormat = Support::format($lottoRecord->created_at);
        $params = [$lottoItem->short_name, $dateFormat, $lottoItem->name, Support::format($lottoRecord->created_at, 'd/m')];
        $currentItem->seo_title = $currentItem->name = vsprintf('%1$s %2$s - Xổ Số %3$s ngày %2$s - %1$s %4$s', $params);
        $currentItem->seo_des = vsprintf('%1$s %2$s - Kết quả xổ số %3$s ngày %2$s trực tiếp từ trường quay.✅ %1$s %4$s, KQ%1$s ngày %2$s nhanh top 1 #1 VN', $params);
        $currentItem->seo_key = vsprintf('%1$s %2$s, Xổ số %3$s ngày %5$s tháng %6$s năm %7$s, KQ%1$s ngày %2$s, %1$s %4$s', array_merge($params, [$lottoRecord->created_at->day, $lottoRecord->created_at->month, $lottoRecord->created_at->year]));
        return $currentItem;
    }
}
