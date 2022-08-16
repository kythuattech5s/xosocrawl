@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('page', $currentItem)}}
@endsection
@section('main')
@if (count($listItems) > 0)
    <ul class="dientoan-ball clearfix">
        @foreach ($listItems as $key => $item)
            <div class="box">
                {!!$item->name_content!!}
                {!!$item->content!!}
            </div>
        @endforeach
    </ul>
@else
    <p class="pad10">Tạm thời chưa có kết quả nào.</p>
@endif
<div class="box">
    @if (count($listItems) > 0)
        {{ $listItems->withQueryString()->links('vendor.pagination.pagination') }}
    @endif
    @if ($listItems->total() == 1)
        <div class="loading-page clearfix">
            <a class="secondary" href="{{$currentItem->slug}}" title="Đầu trang">
                <b> Đầu trang </b>
            </a>
        </div>
    @endif
</div>
<div class="box">
    <div class="pad5">
        <div class="box-note">
            {!!Support::show($currentItem,'content')!!}
        </div>
    </div>
</div>
@endsection