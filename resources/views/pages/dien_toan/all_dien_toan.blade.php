@php
    $dayOfWeekNameMap = [
        0 => 'Chủ nhật',
        1 => 'Thứ 2',
        2 => 'Thứ 3',
        3 => 'Thứ 4',
        4 => 'Thứ 5',
        5 => 'Thứ 6',
        6 => 'Thứ 7',
    ]
@endphp
@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('static','Xổ số điện toán ngày '.$activeTime->format('d-m-Y'),'ket-qua-xo-so-dien-toan-ngay-'.$activeTime->format('d-m-Y'))}}
@endsection
@section('main')
<div class="box info-city">
    <h2 class="tit-mien"><strong>KQXS Điện toán 1 2 3, 6x36, thần tài {{$dayOfWeekNameMap[$activeTime->dayOfWeek]}} ngày {{$activeTime->format('d/m/Y')}}</strong></h2>
    @include('pages.dien_toan.all_dien_toan_content')
</div>
@endsection