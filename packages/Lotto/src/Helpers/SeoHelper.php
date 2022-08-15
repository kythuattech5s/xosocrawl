<?php

namespace Lotto\Helpers;

use Illuminate\Support\Str;
use Lotto\Dtos\LottoItemMnCollection;
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
    public static function getSeoMienXDow(LottoCategory $lottoCategory, LottoItemMnCollection $lottoItemMnCollection)
    {
        $lottoItems = $lottoItemMnCollection->getLottoItems();
        $lottoRecord = $lottoItemMnCollection->getLottoRecord();
        $date = $lottoRecord->created_at;
        $dayOfWeek = DayOfWeek::fromDate($date);
        $currentItem = new \stdClass;
        if ($lottoCategory->id == 3) {
            $currentItem->seo_title = $currentItem->name = vsprintf(
                'XSMN %1$s- Xổ Số Miền Nam %1$s hàng tuần - XSMN %2$s - SXMN thu 2',
                [$dayOfWeek->toFullString(), $dayOfWeek->toMiniString(), Str::slug($dayOfWeek->toFullString(), ' ')]
            );
            $currentItem->seo_key = vsprintf(
                'KQXSMN %1$s, XSMN %1$s, SXMN %1$s,XSMN %2$s,KQXSMN %2$s,SXMN %2$s,Xổ số miền Nam %1$s,Xo so mien Nam %2$s, Kết quả xổ số miền Nam %1$s, Ket qua xo so mien Nam %2$s, XSMN %3$s, SXMN %3$s',
                [$dayOfWeek->toFullString(), Str::slug($dayOfWeek->toFullString(), ' '), $dayOfWeek->toMiniString()]
            );
            $currentItem->seo_des = vsprintf(
                'XSMN %1$s - Kết quả xổ số miền Nam %1$s hàng tuần trực tiếp vào 16h10 - XSMN %2$s.✅ KQXSMN %1$s - Xổ số %4$s đài thứ hai: %5%s, SXMN %3$s',
                [$dayOfWeek->toFullString(), $dayOfWeek->toMiniString(), Str::slug($dayOfWeek->toFullString(), ' '),  count($lottoItems), $lottoItems->implode('name', ', ')]
            );
        } else {
            $currentItem->seo_title = $currentItem->name = vsprintf(
                '%1$s %2$s- %3$s %2$s hàng tuần - %1$s %4$s - SXMT %5$s',
                [$lottoCategory->short_name, $dayOfWeek->toFullString(), $lottoCategory->name, $dayOfWeek->toShortString(), Str::slug($dayOfWeek->toFullString(), ' ')]
            );

            $currentItem->seo_key = vsprintf(
                'KQXSMT %1$s, XSMT %1$s, XSMT %2$s, SXMT %1$s, Kết quả xổ số miền Trung %1$s, Ket qua xo so mien Trung %3$s, SXMT %2$s, XSMT%2$s, SXMT%2$s, XSMT %2$s HT',
                [$dayOfWeek->toFullString(), $dayOfWeek->toMiniString(), Str::slug($dayOfWeek->toFullString(), ' ')]
            );
            $currentItem->seo_des = vsprintf(
                '%1$s %2$s - Kết Quả Xổ Số Miền Trung %2$s hàng tuần trực tiếp vào 17h10 - %1$s %4$s.✅ KQ%1$s %2$s - %1$sRUNG %2$s nhanh SỐ #1, SXMT %3$s, %1$sR %3$s',
                [$lottoCategory->short_name, $dayOfWeek->toFullString(), Str::slug($dayOfWeek->toFullString(), ' '), $dayOfWeek->toMiniString()]
            );
        }

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
    public static function getSeoMienXCategory(LottoCategory $lottoCategory)
    {
        $currentItem = new \stdClass;
        if ($lottoCategory->id == 3) {
            $currentItem->seo_title = $currentItem->name =
                'XSMN - SXMN - Xổ Số Miền Nam hôm nay - KQXSMN - XS Miền Nam - XSKTMN';
            $currentItem->seo_des = 'XSMN - SXMN - Kết Quả Xổ Số Miền Nam hôm nay nhanh số #1 - KQXSMN. Xổ Số Kiến Thiết miền Nam 3 đài chính xác 100%, XS Mien Nam, XSKTMN, XSNM, SSMN, KQSXMN';
            $currentItem->seo_key =
                'XSMN, SXMN, KQXSMN, XS miền nam, kết quả XSMN, KQXS miền nam, kết quả xổ số miền nam, ket qua xo so mien nam, XSNM, KQSXMN, SSMN, XSKT Miền Nam, Xổ số MN, Xo so MN, XSMNHN, XSMN HN, SXMN HN, XS Miền Nam, KQSSMN, XSMNAM, XSKTMN, XS NM, xổ số đại nam, SX MN, XS MN,';
        } else {
            $currentItem->seo_title = $currentItem->name = "XSMT - XSMTR - SXMT - Xổ Số Miền Trung hôm nay - KQXSMT - XSMTRUNG";
            $currentItem->seo_des = "XSMT - XSMTR - SXMT - Kết quả xổ số miền Trung hôm nay trực tiếp lúc 17h10 từ trường quay xổ số kiến thiết Miền Trung - KQXSMT - XSMTRUNG - XSKTMT, XS mien Trung, KQ SX MT";
            $currentItem->seo_key = 'XSMT, SXMT, KQXSMT, Xổ số miền trung, Xo so mien Trung, kết quả XSMT, KQXS miền trung, kết quả xổ số miền trung, kết quả xổ số miền trung hôm nay, ket qua xo so mien trung, XSMTR, KQXSMTRUNG, XSKT Miền Trung, XSKTMT, SXKTMT, KQSX MT, xs miền trung, xs mien trung, xsmtrung';
        }
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
    public static function getSeoMienXDmY(LottoCategory $lottoCategory, LottoItem $lottoItem, LottoRecord $lottoRecord)
    {
        $date = $lottoRecord->created_at;
        $currentItem = new \stdClass;
        if ($lottoCategory->id == 3) {
            $currentItem->seo_title = $currentItem->name = vsprintf(
                '%1$s %2$s - %3$s ngày %4$s',
                [$lottoCategory->short_name, $date->format('d/m/Y'), $lottoCategory->name, $date->format('j/n/Y')]
            );
            $currentItem->seo_key = vsprintf(
                'Kết quả %1$s %2$s, %3$s %2$s, Kết quả %1$s ngày %4$s, SXMN %4$s',
                [$lottoCategory->name, Support::format($date, 'd/m/Y'), $lottoCategory->name, Support::format($date, 'j/n/Y')]
            );
            $currentItem->seo_des = vsprintf(
                '%1$s %2$s - Trực tiếp kết quả %3$s ngày %2$s lúc 16h10.✅ KQ%1$s %4$s nhanh và chính xác top #1 Việt Nam, %1$s %4$s',
                [$lottoCategory->short_name, Support::format($date, 'd/m/Y'), $lottoCategory->name, Support::format($date, 'j/n/Y')]
            );
        } else {
            $currentItem->seo_title = $currentItem->name = vsprintf(
                '%1$s %2$s - %3$s ngày %4$s',
                [$lottoCategory->short_name, $date->format('d/m/Y'), $lottoCategory->name, $date->format('j/n/Y')]
            );
            $currentItem->seo_key = vsprintf(
                'Kết quả %1$s %2$s, %3$s %2$s, Kết quả %1$s ngày %4$s, SXMT %4$s',
                [$lottoCategory->name, Support::format($date, 'd/m/Y'), $lottoCategory->name, Support::format($date, 'j/n/Y')]
            );
            $currentItem->seo_des = vsprintf(
                '%1$s %2$s - Trực tiếp kết quả %3$s ngày %2$s lúc 17h10.✅ KQ%1$s %4$s nhanh và chính xác top #1 Việt Nam, %1$s %4$s',
                [$lottoCategory->short_name, Support::format($date, 'd/m/Y'), $lottoCategory->name, Support::format($date, 'j/n/Y')]
            );
        }

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
