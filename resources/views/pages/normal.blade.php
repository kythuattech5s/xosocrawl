@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('page', $currentItem)}}
@endsection
@section('main')
    <div class="box box-detail pad10">
        {!!Support::show($currentItem,'content')!!}
    </div>
@endsection