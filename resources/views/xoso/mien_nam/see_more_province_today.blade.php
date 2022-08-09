<div class="see-more">
    <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm:</div>
    <ul class="list-html-link two-column">
        <li>Xem thêm <a href="thong-ke-lo-gan-xo-so-bac-lieu-xsbl" title="Thống kê lô gan Bạc Liêu">thống kê lô gan
                Bạc Liêu</a>
        </li>
        @if ($testSpin = $lottoItem->testSpin)
            <li>Xem thêm <a href="{{ $testSpin->slug }}"
                    title="{{ $testSpin->short_name }}">{{ $testSpin->short_name }}</a>
            </li>
        @endif
        <li>Xem thêm <a href="xsmn-sxmn-kqxsmn-ket-qua-xo-so-mien-nam" title="kết quả xổ số miền Nam">kết quả xổ số
                miền Nam</a>
        </li>
        @if ($lottoCategory = $lottoItem->lottoCategory)
            <li>Xem thêm <a href="{{ $lottoCategory->linkDayOfWeek($lottoRecord) }}"
                    title="{{ $lottoCategory->name }} {{ $lottoRecord->dayOfWeek()->toFullString() }}">{{ $lottoCategory->name }}
                    {{ $lottoRecord->dayOfWeek()->toFullString() }}</a>
            </li>
        @endif
        <li>Xem thêm <a href="/" title="kết quả xổ số kiến thiết">kết quả xổ số kiến thiết</a>
        </li>
    </ul>
</div>
