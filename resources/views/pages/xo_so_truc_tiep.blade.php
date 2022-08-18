@extends('index')
@section('main')
<div class="box">
    <div class="bg_gray">
        <div class=" opt_date_full clearfix">
            <label>
            <strong>{{Support::getDayOfWeekName(now())}}</strong> - <input type="text" class="nobor" value="{{now()->format('d/m/Y')}}" id="searchDate"/>
                <span class='ic ic-calendar'></span>
            </label>
        </div>
    </div>
</div>
@foreach ($arrData as $item)
    <div class="box">
        @if ($item['lottoCategory']->id != 1)
            @include('xoso.breadcrumbs.mien_nam_dow',$item)
            <div id="load_kq_m{{$item['lottoCategory']->id == 3 ? 'n':'t'}}_0">
                @include('xoso.mien_nam.result_table',$item)
                @include('xoso.mien_nam.head_tail',$item)
            </div>
        @else
            @include('xoso.breadcrumbs.mien_bac_dow',$item)
            <div id="load_kq_mb_0">
                @include('xoso.result_table',$item)
                <div class="txt-center">
                    <div class="center">
                        @include('xoso.ads.banner_between_result_table')
                    </div>
                </div>
                @include('xoso.head_tail',$item)
                <div class="clearfix">
                </div>
                <div class="bg_brown clearfix">
                    <a class="conect_out " href="in-ve-do" rel="nofollow" title="In vé dò">
                        In vé dò </a>
                </div>
            </div>
        @endif
        <div class="see-more">
            <ul class="list-unstyle list-html-link">
                @if ($item['lottoCategory']->id == 1)
                    <li>Tham gia <a href="quay-thu-xsmb-quay-thu-xo-so-mien-bac" title="Quay thử XSMB">quay thử XSMB</a> để thử vận may</li>
                    <li>Xem cao thủ <a href="du-doan-ket-qua-xo-so-mien-bac-xsmb-c228" title="Dự đoán XSMB">dự đoán XSMB</a> siêu chính xác</li>
                    <li>Xem thêm <a href="thong-ke-lo-gan-xo-so-mien-bac-xsmb" title="Thống kê lô gan miền Bắc">thống kê lô gan miền Bắc</a></li>
                    <li>Xem thêm <a href="xo-so-truc-tiep/xsmb-mien-bac" title="Xổ số miền Bắc trực tiếp">xổ số miền Bắc trực tiếp</a> nhanh nhất</li>
                @endif
                @if ($item['lottoCategory']->id == 3)
                    <li>Xem cao thủ <a href="du-doan-ket-qua-xo-so-mien-nam-xsmn-c226" title="Dự đoán XSMN">dự đoán XSMN</a> hôm nay chính xác nhất</li>
                    <li>Xem thống kê <a href="lo-gan-mn-thong-ke-lo-gan-mien-nam" title="Lô gan miền Nam">lô gan miền Nam</a></li>
                    <li>Xem kết quả <a href="xo-so-truc-tiep/xsmn-mien-nam" title="Xổ số miền Nam trực tiếp">xổ số miền Nam trực tiếp</a></li>
                    <li>Tham gia <a href="quay-thu-xsmn-quay-thu-xo-so-mien-nam" title="Quay thử XSMN">quay thử XSMN</a> để thử vận may</li>
                @endif
                @if ($item['lottoCategory']->id == 4)
                    <li>Xem cao thủ <a href="du-doan-ket-qua-xo-so-mien-trung-xsmt-c224" title="Dự đoán XSMT">dự đoán XSMT</a> siêu chính xác</li>
                    <li>Xem thống kê <a href="lo-gan-mt-thong-ke-lo-gan-mien-trung" title="Lô gan miền Trung">lô gan miền Trung</a></li>
                    <li>Tham gia <a href="quay-thu-xsmt-quay-thu-xo-so-mien-trung" title="Quay thử XSMT">quay thử XSMT</a> để thử vận may</li>
                    <li>Xem kết quả <a href="xo-so-truc-tiep/xsmt-mien-trung" title="Xổ số miền Trung trực tiếp">xổ số miền Trung trực tiếp</a> nhanh nhất</li>
                @endif
            </ul>
        </div>
    </div>
@endforeach
<div class="box box-html">
    {!!Support::show($currentItem,'content')!!}
</div>
@endsection