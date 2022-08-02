@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('test_spin_categories', $currentItem)}}
@endsection
@section('main')
<div class="col-l">
    <div class="box quay-thu">
        <ul class="tab-panel tab-auto">
            @foreach ($listItemTestSpinCategory as $item)
                <li class="{{$item->id == $currentItem->id ? 'active':''}}">
                    <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'short_name')}}">{{Support::show($item,'short_name')}}</a>
                </li>
            @endforeach
        </ul>
        <div class="tit-mien clearfix">
            <h2>
                @if ($currentItem->id == 1)
                    Quay thử {{Support::show($currentItem,'main_area_name')}} ngày {{now()->format('d-m-Y')}}
                @else
                    Quay thử {{Support::show($currentItem,'main_area_name')}} ngày {{now()->format('d-m-Y')}}
                @endif
            </h2>
        </div>
        <div class="box" id="trial-box">
            <div class="txt-center bg-orange">
                <form id="trial_form" class="form-horizontal" action="{{Support::show($currentItem,'slug')}}" method="post" accept-charset="utf8">
                    @csrf
                    <div class="form-group">
                        <select id="province_name" name="province_name" onchange="document.getElementById('trial_form').submit();">
                            <option value="">Chọn đài quay thử</option>
                            @if ($currentItem->id == 1)
                                <option value="mien-bac" selected>Miền Bắc</option>
                            @endif
                            @foreach ($listItems as $item)
                                <option value="{{Support::show($item,'province_code')}}">{{Support::show($item,'province_name')}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group txt-center">
                        <button type="button" class="btn btn-danger trial-button" data-interval="3000">Bắt đầu quay</button>
                        <button type="button" class="btn btn-light trial-button" data-interval="500">Quay nhanh</button>
                    </div>
                    <div class="form-group txt-center">
                        Quay thử đài: 
                        @foreach ($listActiveTestSpinToday as $itemActiveTestSpinToday)
                            <a class="item_sublink mag-l5" href="{{Support::show($itemActiveTestSpinToday,'slug')}}">
                                {{Support::show($itemActiveTestSpinToday,'province_name')}}
                            </a>
                        @endforeach
                    </div>
                </form>
            </div>
            @include('test_spins.result_box')
            <div class="clearfix"></div>
            <div class="see-more">
                <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm:</div>
                <ul class="list-html-link two-column">
                    <li>Xem thêm <a href="https://xoso.me/thong-ke-tan-suat-lo-to-xo-so-mien-bac-xsmb.html">thống kê tần suất lô tô miền Bắc</a></li>
                    <li>Xem thêm <a href="https://xoso.me/thong-ke-giai-dac-biet-theo-tong.html">thống kê theo tổng miền Bắc</a></li>
                    <li>Xem thêm <a href="https://xoso.me/thong-ke-lo-gan-xo-so-mien-bac-xsmb.html" title="thống kê lô gan miền Bắc">thống kê lô gan miền Bắc</a></li>
                    <li>Xem thêm <a href="/thong-ke-giai-dac-biet-xo-so-mien-bac-xsmb.html" title="thống kê giải đặc biệt miền Bắc">thống kê giải đặc biệt miền Bắc</a></li>
                    <li>Xem thêm <a href="/soi-cau-bach-thu-lo-to-xsmb-hom-nay.html">soi cầu bạch thủ lô tô miền Bắc</a></li>
                    <li>Xem thêm <a href="/soi-cau-giai-dac-biet-mien-bac.html">soi cầu giải đặc biệt miền Bắc</a></li>
                    <li>Xem cao thủ <a href="https://xoso.me/du-doan-ket-qua-xo-so-mien-bac-xsmb-c228.html" title="dự đoán miền Bắc">dự đoán miền Bắc</a></li>
                    <li>Xem ngay <a href="https://xoso.me/xsmb-sxmb-xstd-xshn-kqxsmb-ket-qua-xo-so-mien-bac.html">kết quả xổ số miền Bắc</a></li>
                </ul>
            </div>
        </div>
    </div>
    @include('test_spins.lucky_box')
    <div class="box box-html">
        {!!Support::show($currentItem,'content')!!}
    </div>
    <div class="box box-news">
        <h3 class="tit-mien"><strong>Thảo luận kết quả xổ số</strong></h3>
        <ul>
            <li>
                <span class="ic"></span><a href="dien-dan-xo-so">Box thảo luận</a>
            </li>
        </ul>
    </div>
    <div class="box">
        <h3 class="tit-mien"><strong>Thảo luận</strong></h3>
        <div id="comment" class="fb-comments" data-href="{{url()->to($currentItem->slug)}}" data-width="100%" data-numposts="5"></div>
    </div>
</div>
@endsection