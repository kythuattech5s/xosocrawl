@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('static','Kết quả điện toán',$currentItem->slug)}}
@endsection
@section('main')
<div class="box info-city">
    <h2 class="tit-mien"><strong>Kết quả xổ số điện toán ngày hôm nay</strong></h2>
    @include('pages.dien_toan.all_dien_toan_content')
</div>
<div class="box box-html">
    {!!Support::show($currentItem,'content')!!}
</div>
@endsection