<ul class="dientoan clearfix">
    @if (isset($firstItem))
        <li class="first">
            <h2 class="pad10-5"><strong>{{Support::show($firstItem,'name')}}</strong></h2>
            <div>
                @foreach (explode(',',$firstItem->list_number) as $itemNumber)
                    <span>{{$itemNumber}}</span>
                @endforeach
            </div>
        </li>
    @endif
    @if (isset($secondItem))
        <li class="second">
            <h2 class="pad10-5"><strong>{{Support::show($secondItem,'name')}}</strong></h2>
            <div>
                @foreach (explode(',',$secondItem->list_number) as $itemNumber)
                    <span>{{$itemNumber}}</span>
                @endforeach
            </div>
        </li>
    @endif
    @if (isset($lastItem))
        <li class="last">
            <h2 class="pad10-5"><strong>{{Support::show($lastItem,'name')}}</strong></h2>
            <div>
                @foreach (explode(',',$lastItem->list_number) as $itemNumber)
                    <span>{{$itemNumber}}</span>
                @endforeach
            </div>
        </li>
    @endif
</ul>
<div class="box pad10-5">
    <ul class="list-dot-red">
        @for ($i = 1; $i <= 3; $i++)
            @php
                $time = $activeTime->subDays(1);
            @endphp
            <li>
                <img style="width:6px;height:6px" alt="icon ve so" src="theme/frontend/images/bullet-red.png">
                <a title="Kết quả điện toán ngày {{Support::showDateTime($time,'d-m-Y')}}" href="ket-qua-xo-so-dien-toan-ngay-{{Support::showDateTime($time,'d-m-Y')}}">
                    Kết quả điện toán ngày {{Support::showDateTime($time,'d-m-Y')}}
                </a>
            </li>
        @endfor
    </ul>
</div>
<div class="see-more">
    <ul class="list-html-link two-column">
        <li>Xem thêm <a href="thong-ke-lo-gan-xo-so-mien-bac-xsmb" title="thống kê lô gan miền Bắc">thống kê lô gan miền Bắc</a></li>
        <li>Xem thêm <a href="thong-ke-giai-dac-biet-xo-so-mien-bac-xsmb" title="thống kê giải đặc biệt miền Bắc">thống kê giải đặc biệt miền Bắc</a></li>
        <li>Xem cao thủ <a href="du-doan-ket-qua-xo-so-mien-bac-xsmb-c228" title="dự đoán miền Bắc">dự đoán miền Bắc</a> hôm nay chính xác nhất</li>
        <li>Tham gia <a href="quay-thu-xsmb-quay-thu-xo-so-mien-bac" title="quay thử miền Bắc">quay thử miền Bắc</a> để thử vận may</li>
        <li>Hãy soi <a href="soi-cau-bach-thu-lo-to-xsmb-hom-nay">cầu bạch thủ miền Bắc</a> để chọn bộ số ngon nhất</li>
        <li>Xem thêm bảng kết quả <a href="xsmb-30-ngay-so-ket-qua-xo-so-kien-thiet-mien-bac">XSMB 30 ngày</a></li>
        <li>Mời bạn xem <a href="xsmb-sxmb-xstd-xshn-kqxsmb-ket-qua-xo-so-mien-bac">xổ số miền Bắc hôm nay</a> từ trường quay</li>
    </ul>
</div>