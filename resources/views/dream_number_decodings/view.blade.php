@extends('index')
@section('breadcrumb')
<div class="linkway">
    <div class="main">
        {{Breadcrumbs::render('dream_number_decodings', $currentItem)}}
    </div>
</div>
@endsection
@section('main')
<div class="box-detail box">
    <div class="search-dream bg_f9">
        <div class="box-search clearfix">
            <form id="w0" action="https://xoso.me/so-mo-lo-de-mien-bac-so-mo-giai-mong.html" method="post">
                <input type="hidden" name="_csrf" value="PjhtUBIipapCrEMfo8DI3CvCY9lHOjkzuJ0Ew5E4PN9GSV8_IUP__AHuGWz594qdUZcJlAF1TWTi1HS6_W9rlg==">
                <span class="bor-1 fl">
                    <input name="tukhoa" type="search" value="">
                </span>
                <button class="fl" type="submit">
                    <strong>Tìm kiếm</strong>
                </button>
            </form>
        </div>
        <h1 class="font-20 bold pad5">{{Support::show($currentItem,'name')}}</h1>
        <div class="table-dream">
            <table class="bold">
                <thead>
                    <tr>
                        <th>Bạn mơ thấy gì</th>
                        <th>Cặp số tương ứng</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{Support::show($currentItem,'key_name')}}</td>
                        <td>{{Support::show($currentItem,'number_decoding')}}</td>
                    </tr>
                </tbody>
            </table>
            <div class="cont-dream s-content pad10-5 cont-detail paragraph">
                {!!Support::show($currentItem,'content')!!}
            </div>
        </div>
    </div>
    @if (count($listMostView) > 0)
        <div class="see-more ">
            <h3 class="tit-mien">
                <strong>Các giấc mơ xem nhiều</strong>
            </h3>
            <ul class="list-html-link two-column">
                @foreach ($listMostView as $itemMostView)
                    <li>
                        <a href="{{Support::show($itemMostView,'slug')}}" title="{{Support::show($itemMostView,'name')}}">{{Support::show($itemMostView,'name')}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (count($listSuggestion) > 0)
        <div class="box sugges-dream">
            <h2 class="tit-mien">
                <strong>Gợi ý mơ thấy</strong>
            </h2>
            <table class="">
                <tbody>
                    @foreach ($listSuggestion as $itemSuggestion)
                        <tr>
                            <td>
                                <a href="{{Support::show($itemSuggestion,'slug')}}" title="{{Support::show($itemSuggestion,'key_name')}}">
                                    <strong class="clred">{{Support::show($itemSuggestion,'key_name')}}</strong>
                                </a>
                            </td>
                            <td>
                                <strong class="cl-green">{{Support::show($itemSuggestion,'number_decoding')}}</strong>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <div class="see-more">
        <h3 class="tit-mien">
            <strong>Xem thêm tiện ích dưới đây</strong>
        </h3>
        <ul class="list-html-link two-column">
            <li>Xem thêm <a href="xsmb-sxmb-xstd-xshn-kqxsmb-ket-qua-xo-so-mien-bac" title="Kết quả xổ số miền Bắc hôm nay">kết quả xổ số miền Bắc hôm nay</a>
            </li>
            <li>Xem thêm <a href="thong-ke-lo-gan-xo-so-mien-bac-xsmb" title="Thống kê lô gan">thống kê lô gan miền Bắc</a>
            </li>
            <li>Xem cao thủ <a href="du-doan-ket-qua-xo-so-mien-bac-xsmb-c228" title="Dự đoán XSMB">dự đoán XSMB</a> hôm nay chính xác nhất </li>
            <li>Xem thêm <a href="thong-ke-giai-dac-biet-xo-so-mien-bac-xsmb" title="thống kê giải đặc biệt miền Bắc">thống kê giải đặc biệt miền Bắc</a>
            </li>
            <li>Xem thêm <a href="quay-thu-xsmb-quay-thu-xo-so-mien-bac" title="quay thử xổ số miền Bắc">quay thử xổ số miền Bắc</a>
            </li>
        </ul>
    </div>
</div>
<div class="box box-comment">
    <div class="fb-comments" data-href="{{url()->to($currentItem->slug)}}" data-width="100%" data-numposts="5"></div>
</div>
@endsection