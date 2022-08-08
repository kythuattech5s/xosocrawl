    <div class="see-more">
        <div class="bold see-more-title">Xem theo ngày:</div>
        <ul class="list-html-link">
            @php
                $today = $lottoRecord->created_at->format('Ymd');
            @endphp
            @for ($i = 0; $i < 5; $i++)
                @php
                    $date = now()->addDays(-$i);
                @endphp
                @if ($date->format('Ymd') != $today)
                    <li>
                        <a href="{{ $lottoCategory->linkCustomDate($date) }}"
                            title="{{ $lottoCategory->short_name }} ngày {{ $date->format('j-n-Y') }}">{{ $lottoCategory->short_name }}
                            ngày
                            {{ $date->format('j-n-Y') }}</a>
                        @if ($i == 0)
                            (hôm nay)
                        @endif
                    </li>
                @endif
            @endfor
        </ul>
    </div>
    <div class="see-more">
        <div class="bold see-more-title">Xem kết quả miền theo ngày:</div>
        <ul class="list-html-link">
            <?php $categories = \Lotto\Models\LottoCategory::whereIn('id', [3, 4])->get();
            $now = now(); ?>
            @foreach ($categories as $category)
                <li>Xem thêm <a href="{{ $category->linkCustomDate($now) }}"
                        title="{{ $category->short_name }} {{ $now->format('j-n-Y') }}">{{ $category->short_name }}
                        {{ $now->format('j-n-Y') }}</a> (hôm nay) </li>
            @endforeach
        </ul>
    </div>
    <div class="see-more">
        <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm:</div>
        <ul class="list-html-link two-column">
            <li>Xem thêm <a href="thong-ke-lo-gan-xo-so-mien-bac-xsmb" title="thống kê lô gan miền Bắc">thống kê lô gan
                    miền Bắc</a>
            </li>
            <li>Xem thêm <a href="/thong-ke-giai-dac-biet-xo-so-mien-bac-xsmb"
                    title="thống kê giải đặc biệt miền Bắc">thống kê giải đặc biệt miền Bắc</a>
            </li>
            <li>Xem thêm <a href="du-doan-ket-qua-xo-so-mien-bac-xsmb-c228" title="dự đoán xổ số miền Bắc">dự đoán xổ số
                    miền Bắc</a>
            </li>
            <li>Xem thêm <a href="quay-thu-xsmb-quay-thu-xo-so-mien-bac" title="quay thử xổ số miền Bắc">quay thử xổ số
                    miền Bắc</a>
            </li>
            <li>Xem thêm <a href="/" title="xổ số 3 miền">xổ số 3 miền</a>
            </li>
        </ul>
    </div>
