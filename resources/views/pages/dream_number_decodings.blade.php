@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('page', $currentItem)}}
@endsection
@section('main')
<div class="box-dream box">
    <h2 class="tit-mien mag0">
        <strong> Giải mã giấc mơ - giải mộng chiêm bao </strong>
    </h2>
    <div class="search-dream pad10">
        @include('dream_number_decodings.form_search_dream_number')
        @if (count($listItems) > 0)
            <table class="bold">
                <tbody>
                    <tr>
                        <th> STT </th>
                        <th> Chiêm bao thấy </th>
                        <th> Con số giải mã </th>
                    </tr>
                </tbody>
                <tbody>
                    @foreach ($listItems as $key => $item)
                        <tr>
                            <td> {{($listItems->currentPage() - 1)*20 + $key + 1}} </td>
                            <td>
                                <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'key_name')}}">
                                    <strong class="clred">{{Support::show($item,'key_name')}}</strong>
                                </a>
                            </td>
                            <td>{{Support::show($item,'number_decoding')}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            Không tồn tại con số như giấc mơ bạn tìm :)
        @endif
    </div>
    @if (count($listItems) > 0)
        {{ $listItems->withQueryString()->links('vendor.pagination.pagination') }}
    @endif
    @if ($listItems->total() == 1)
        <div class="loading-page clearfix">
            <a class="secondary" href="so-mo-lo-de-mien-bac-so-mo-giai-mong" title="Đầu trang">
                <b> Đầu trang </b>
            </a>
        </div>
    @endif
</div>
<div class="box">
    @if (count($listMostView) > 0)
        <h3 class="tit-mien">
            <strong>Các giấc mơ xem nhiều</strong>
        </h3>
        <div class="see-more ">
            <ul class="list-html-link two-column">
                @foreach ($listMostView as $itemMostView)
                    <li>
                        <a href="{{Support::show($itemMostView,'slug')}}" title="{{Support::show($itemMostView,'name')}}">{{Support::show($itemMostView,'name')}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @include('dream_number_decodings.list_utility')
</div>
<div class="box">
    <div class="box-nd">
        <div class="pad10 s-content">
            {!!$currentItem->content!!}
        </div>
    </div>
</div>
@endsection