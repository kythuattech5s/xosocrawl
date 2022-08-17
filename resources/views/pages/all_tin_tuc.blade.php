@php
    $dayOfWeekNameMap = [
        0 => 'Chủ nhật',
        1 => 'Thứ hai',
        2 => 'Thứ ba',
        3 => 'Thứ bốn',
        4 => 'Thứ năm',
        5 => 'Thứ sáu',
        6 => 'Thứ bảy'
    ]
@endphp
@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('static', $currentItem->name,$currentItem->slug)}}
@endsection
@section('main')
<div class="box cate-news">
    <h2 class="tit-mien"><strong>{{Support::show($currentItem,'name')}}</strong></h2>
    <ul>
        @foreach ($listItems as $item)
            <li class="clearfix">
                <h3>
                    <a href="{{$item->slug}}" title="{{Support::show($item,'name')}}">
                        <strong>{{Support::show($item,'name')}}</strong>
                    </a>
                    <span class="date">{{$dayOfWeekNameMap[$item->created_at->dayOfWeek]}}, ngày {{Support::showDateTime($item->created_at,'d-m-Y')}}</span>
                </h3>
                <a href="{{$item->slug}}" title="{{Support::show($item,'name')}}">
                    <img class="mag-r5 fl" src="{%IMGV2.item.img.-1%}" title="{{Support::show($item,'name')}}" alt="{{Support::show($item,'name')}}">
                </a>
                <p class="mag0 sapo">{{\Str::words($item->seo_des,40)}}</p>
            </li>
        @endforeach
    </ul>
    {{ $listItems->withQueryString()->links('vendor.pagination.pagination_default') }}
    <div class="box pad10 mag10"></div>
</div>
@endsection