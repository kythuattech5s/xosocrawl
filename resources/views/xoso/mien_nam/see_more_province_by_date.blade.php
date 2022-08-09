<div class="see-more">
    <div class="bold see-more-title">Xem theo ngày:</div>
    <ul class="list-html-link">
        <?php $lottoPrv = clone $lottoRecord; ?>
        @for ($i = 0; $i < 5; $i++)
            <?php $lottoPrv = $lottoPrv->prev(); ?>
            <li>Xem <a href="{{ $lottoPrv->link($linkPrefix) }}"
                    title="{{ $lottoItem->short_name }} {{ $lottoPrv->created_at->format('j/n/Y') }}">{{ $lottoItem->short_name }}
                    {{ $lottoPrv->created_at->format('j/n/Y') }}</a> (hôm nay)
            </li>
        @endfor
    </ul>
</div>
<div class="see-more">
    <div class="bold see-more-title">Xem kết quả miền theo ngày:</div>
    <ul class="list-html-link">

        <?php $categories = \Lotto\Models\LottoCategory::whereIn('id', [1, 3, 4])->get();
        $now = now(); ?>
        @foreach ($categories as $category)
            <li>Xem <a href="{{ $category->linkCustomDate($now) }}"
                    title="{{ $category->name }} {{ $now->format('j-n-Y') }}">{{ $category->name }}
                    {{ $now->format('j/n/Y') }} </a>(hôm nay)</li>
        @endforeach
    </ul>
</div>
<div class="see-more">
    <div class="bold see-more-title">Bạn có thể xem thêm:</div>
    <ul class="list-html-link">
        <li>Xem thêm <a href="https://xoso.me/thong-ke-lo-gan-xo-so-bac-lieu-xsbl.html"
                title="thống kê lô gan Bạc Liêu">thống kê lô gan Bạc Liêu</a></li>
        @if ($lottoItem->predictLotteryProvinceResult)
            <li>Xem chuyên gia <a href="{{ $lottoItem->predictLotteryProvinceResult->slug }}"
                    title="{{ $lottoItem->predictLotteryProvinceResult->short_name }}">{{ $lottoItem->predictLotteryProvinceResult->short_name }}</a>
                siêu
                chính xác</li>
        @endif
        @if ($testSpin = $lottoItem->testSpin)
            <li>Hãy tham gia <a href="{{ $testSpin->slug }}"
                    title="{{ $testSpin->short_name }}">{{ $testSpin->short_name }}</a></li>
        @endif

    </ul>
</div>
