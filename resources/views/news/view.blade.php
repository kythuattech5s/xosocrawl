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
    {{Breadcrumbs::render('tin-tuc',$currentItem)}}
@endsection
@section('main')
<div class="box box-detail pad10">
    <h1 class="s20"><strong>{{Support::show($currentItem,'name')}}</strong></h1>
    <p class="date">{{$dayOfWeekNameMap[$currentItem->created_at->dayOfWeek]}}, ngày {{Support::showDateTime($currentItem->created_at,'d-m-Y')}}
    </p>
    <div class="cont-detail paragraph">
        {!!Support::show($currentItem,'content')!!}
    </div>
</div>
<div class="box">
    <div class="fb-comments" data-href="{{url()->to($currentItem->slug)}}" data-width="100%" data-numposts="5"></div>
</div>
@endsection