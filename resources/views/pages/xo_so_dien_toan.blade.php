@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('static','Kết quả điện toán',$currentItem->slug)}}
@endsection
@section('main')
<div class="box">
    <div class="box box-html">
        {!!Support::show($currentItem,'content')!!}
    </div>
</div>
@endsection