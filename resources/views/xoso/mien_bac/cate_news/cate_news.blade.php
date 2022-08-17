<div class="box cate-news">
    <div class="tit-mien bold">
        <a class="title-a" href="du-doan-ket-qua-xo-so-mien-bac-xsmb-c228" title="Dự đoán miền Bắc">Dự đoán xổ số miền Bắc
            hôm nay</a>
    </div>
    <ul class="list_view list-unstyle">
        @foreach ($lottoCategory->getPredictNews() as $key => $news)
            @if ($key == 0)
                <li class="clearfix">
                    <a href="{{ $news->slug }}" title="{{ $news->name }}">
                        <img class="mag-r5 fl" src="{%IMGV2.news.img.-1%}" title="{{ $news->name }}"
                            alt="{{ $news->name }}">
                    </a>
                    <a class="bold" href="{{ $news->slug }}" title="{{ $news->name }}">{{ $news->name }}</a>
                </li>
            @else
                <li class="clearfix">
                    <a href="{{ $news->slug }}" title="{{ $news->name }}">{{ $news->name }}</a>
                </li>
            @endif
        @endforeach
    </ul>
</div>
<div class="see-more">
    <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm:</div>
    <ul class="list-html-link two-column">
        <li>Xem thêm <a href="thong-ke-lo-gan-xo-so-mien-bac-xsmb" title="thống kê lô gan miền Bắc">thống kê lô gan miền
                Bắc</a>
        </li>
        <li>Xem thêm <a href="thong-ke-giai-dac-biet-xo-so-mien-bac-xsmb" title="thống kê giải đặc biệt miền Bắc">thống
                kê giải đặc biệt miền Bắc</a>
        </li>
        <li>Xem cao thủ <a href="du-doan-ket-qua-xo-so-mien-bac-xsmb-c228" title="dự đoán miền Bắc">dự đoán miền Bắc</a>
            hôm nay chính xác nhất </li>
        <li>Tham gia <a href="quay-thu-xsmb-quay-thu-xo-so-mien-bac" title="quay thử miền Bắc">quay thử miền Bắc</a> để
            thử vận may </li>
        <li>Hãy soi <a href="soi-cau-bach-thu-lo-to-xsmb-hom-nay" title="cầu bạch thủ miền Bắc">cầu bạch thủ miền
                Bắc</a> để chọn bộ số ngon nhất </li>
        <li>Xem thêm bảng kết quả <a href="xsmb-30-ngay-so-ket-qua-xo-so-kien-thiet-mien-bac" title="XSMB 30 ngày">XSMB
                30 ngày</a>
        </li>
        <li>Mời bạn xem <a href="xo-so-truc-tiep/xsmb-mien-bac" title="trực tiếp XSMB">trực tiếp XSMB</a> từ trường quay
        </li>
    </ul>
</div>
