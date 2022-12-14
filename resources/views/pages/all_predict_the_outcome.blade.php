@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('static','Dự đoán KQXS','du-doan-ket-qua-xo-so-kqxs-c229')}}
@endsection
@section('main')
<div class="box cate-news">
    <h2 class="tit-mien"><strong>Dự Đoán kết quả xổ số hôm nay</strong></h2>
    @if (count($listItems) > 0)
        <ul>
            @foreach ($listItems as $item)
                <li class="clearfix">
                    <h3>
                        <a href="{{$item->slug}}" title="{{$item->name}}">
                            <strong>{{$item->name}}</strong>
                        </a>
                    </h3>
                    <a href="{{$item->slug}}" title="{{$item->name}}">
                        <img class="mag-r5 fl" width="120" height="67" src="{%IMGV2.item.img.-1%}" title="{{Support::show($item,'name')}}" alt="{{Support::show($item,'name')}}">
                    </a>
                    <p class="mag0 sapo">{{Str::words($item->seo_des,28)}}</p>
                </li>
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
            <a class="secondary" href="du-doan-ket-qua-xo-so-kqxs-c229" title="Đầu trang">
                <b> Đầu trang </b>
            </a>
        </div>
    @endif
    <div class="box pad10 mag10">
        {!!$currentItem->content!!}
    </div>
</div>
@endsection