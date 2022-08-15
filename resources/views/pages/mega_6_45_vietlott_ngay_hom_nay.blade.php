@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('page', $currentItem)}}
@endsection
@section('main')
<div class="box">
    @include('pages.vietlott_tab_panel',['activePage'=>'mega-6-45'])
    <div class="box box-html">
        {!!Support::show($currentItem,'content')!!}
    </div>
</div>
@endsection