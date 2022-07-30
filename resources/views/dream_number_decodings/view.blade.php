@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('dream_number_decodings', $currentItem)}}
@endsection
@section('main')
<div class="box-detail box">
    <div class="search-dream bg_f9">
        @include('dream_number_decodings.form_search_dream_number')
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
    @include('dream_number_decodings.list_utility')
</div>
<div class="box box-comment">
    <div class="fb-comments" data-href="{{url()->to($currentItem->slug)}}" data-width="100%" data-numposts="5"></div>
</div>
@endsection