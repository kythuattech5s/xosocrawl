@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('predict_lottery_result_categories', $currentItem)}}
@endsection
@section('main')
<div class="box cate-news">
    <h2 class="tit-mien">
        {!!Support::show($currentItem,'related_link')!!}
    </h2>
    @if (count($listItems) > 0)
        <ul>
            @foreach ($listItems as $key => $item)
                <li class="clearfix">
                    <h3>
                        <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'name')}}">
                            <strong>{{Support::show($item,'name')}}</strong>
                        </a>
                    </h3>
                    <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'name')}}">
                        <img class="mag-r5 fl" width="120" height="67" src="{%IMGV2.item.img.-1%}" title="{{Support::show($item,'name')}}" alt="{{Support::show($item,'name')}}"> 
                    </a>
                    <p class="mag0 sapo">{{\Str::words($item->seo_des,28)}}</p>
                </li>
                @if ($key == 0)
                <li class="clearfix">
                    <div class="pad5">
                        <p style="margin: .6rem 0;">
                            {!!$currentItem->short_content!!}
                        </p>
                        @php
                            $testSpinLink = Support::extractJson($currentItem->test_spin_link);
                        @endphp
                        @if (count($testSpinLink) > 0)
                            <p style="text-align:center;margin: .6rem 0;">
                                @foreach ($testSpinLink as $itemTestSpinLink)
                                    <a class="item_sublink" href="{{Support::show($itemTestSpinLink,'title')}}" rel="nofollow" title="{{Support::show($itemTestSpinLink,'name')}}">{{Support::show($itemTestSpinLink,'name')}}</a>
                                @endforeach
                            </p>
                        @endif
                    </div>
                </li>
                @endif
            @endforeach
        </ul>
    @else
        <p class="pad10">Tạm thời chưa có tin dự đoán nào.</p>
    @endif
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
    <div class="box pad10 mag10">
        {!!Support::show($currentItem,'content')!!}
    </div>
</div>
@endsection