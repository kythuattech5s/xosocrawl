<div class="see-more">
    <div class="bold see-more-title">Xem theo ngày:</div>
    <ul class="list-html-link">

        @php
            $today = $lottoRecord->created_at->format('Ymd');
        @endphp
        @for ($i = 0; $i < 3; $i++)
            @php
                $date = now()->addDays(-$i);
            @endphp
            @if ($date->format('Ymd') != $today)
                <li>
                    <a href="{{ $lottoCategory->linkCustomDate($date) }}"
                        title="{{ $lottoCategory->short_name }} ngày {{ $date->format('j-n-Y') }}">{{ $lottoCategory->short_name }}

                        {{ $date->format('j/n/Y') }}</a>
                    @if ($i == 0)
                        (hôm nay)
                    @endif
                </li>
            @endif
        @endfor
        @for ($i = 1; $i < 4; $i++)
            @php
                $date = $lottoRecord->created_at->addDays(-$i);
            @endphp
            <li>
                <a href="{{ $lottoCategory->linkCustomDate($date) }}"
                    title="{{ $lottoCategory->short_name }} ngày {{ $date->format('j-n-Y') }}">{{ $lottoCategory->short_name }}

                    {{ $date->format('j/n/Y') }}</a>

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
            <li>Xem thêm <a href="{{ $category->linkCustomDate($now) }}"
                    title="{{ $category->short_name }} {{ $now->format('j-n-Y') }}">{{ $category->short_name }}
                    {{ $now->format('j-n-Y') }}</a> (hôm nay) </li>
        @endforeach
    </ul>
</div>
@if ($lottoCategory->id == 3)
    <div class="see-more">
        <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm:</div>
        <ul class="list-html-link two-column">
            <li>Xem thêm thống kê <a href="lo-gan-mn-thong-ke-lo-gan-mien-nam" title="lô gan miền Nam">lô gan miền
                    Nam</a>
            </li>
            <li>Xem cao thủ <a href="du-doan-ket-qua-xo-so-mien-nam-xsmn-c226" title="dự đoán miền Nam">dự đoán miền
                    Nam</a>
                siêu chính xác</li>
            <li>Hãy tham gia <a href="quay-thu-xsmn-quay-thu-xo-so-mien-nam" title="quay thử miền Nam">quay thử miền
                    Nam</a>
                để thử vận may</li>
            <li>Xem kết quả <a href="kq-xs-vietlott-truc-tiep-ket-qua-xo-so-vietlott-hom-nay" title="xổ số Vietlott">xổ
                    số
                    Vietlott</a></li>
            <li>Xem kết quả <a href="/" title="Xổ số 3 miền">Xổ số 3 miền</a> từ trường quay</li>
        </ul>
    </div>
@else
    <div class="see-more">
        <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm:</div>
        <ul class="list-html-link">
            <li>Xem thêm thống kê <a href="lo-gan-mt-thong-ke-lo-gan-mien-trung" title="lô gan miền Trung">lô gan
                    miền Trung</a></li>
            <li>Xem cao thủ <a href="du-doan-ket-qua-xo-so-mien-trung-xsmt-c224" title="Dự đoán miền Trung">Dự đoán
                    miền Trung</a></li>
            <li>Tham gia <a href="quay-thu-xsmt-quay-thu-xo-so-mien-trung" title="quay thử miền Trung">quay thử
                    miền Trung</a> để thử vận may</li>
            <li>Xem thêm kết quả <a href="/" title="xổ số 3 miền">xổ số 3 miền</a> nhanh nhất Việt Nam
            </li>
        </ul>
    </div>
@endif
