@php
    use ModuleStatical\Helpers\ModuleStaticalHelper;
@endphp
@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('statical_lottery_northerns', $currentItem)}}
@endsection
@section('main')
<div class="box tbl-row-hover">
    @include('staticals.statical_lottery_northerns.list_tab_panel',['activeId'=>$currentItem->id])
    <h2 class="tit-mien bold">Bảng đặc biệt miền Bắc theo tuần từ {{Support::showDateTime(,'name')}} đến 09-08-2022</h2>
    
    <div class="box box-note">
        <div class="see-more ">
            <ul class="list-html-link two-column">
                @foreach (Support::extractJson($currentItem->related_link) as $itemSeeMore)
                    <li>{{Support::show($itemSeeMore,'name')}} <a href="{{Support::show($itemSeeMore,'link')}}" title="{{Support::show($itemSeeMore,'title')}}">{{Support::show($itemSeeMore,'title')}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="box tbl-row-hover">
    <h3 class="tit-mien bold">Thảo luận</h3>
    <div id="comment" class="fb-comments" data-href="{{url()->to($currentItem->slug)}}" data-width="100%" data-numposts="5"></div>
</div>
<div class="box box-html">
    {!!Support::show($currentItem,'content')!!}
</div>
@endsection