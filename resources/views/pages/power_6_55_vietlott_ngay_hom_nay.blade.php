@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('vietlott_child','Xổ số Power 6/55',$currentItem->slug)}}
@endsection
@section('main')
<div class="box">
    @include('pages.vietlott_tab_panel',['activePage'=>'power-6-55'])
    @if (count($listItems) > 0)
        @foreach ($listItems as $key => $item)
            <div class="power655 mega645">
                {!!$item->name_content!!}
                {!!$item->content!!}
            </div>
            @if ($key == 0 && $listItems->onFirstPage())
                {!!$currentItem->moreinfo!!}
            @endif
            @if ($key == 0)
                <div class="see-more">
                    {!!$currentItem->seemore_box!!}
                </div>
            @endif
        @endforeach
    @else
        <p class="pad10">Tạm thời chưa có kết quả nào.</p>
    @endif
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
    <div class="box box-html">
        {!!Support::show($currentItem,'content')!!}
    </div>
</div>
@endsection