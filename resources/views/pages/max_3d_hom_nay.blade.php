@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('vietlott_child','Xổ số Max 3D',$currentItem->slug)}}
@endsection
@section('main')
<div class="box">
    @include('pages.vietlott_tab_panel',['activePage'=>'max-3d'])
    @if (count($listItems) > 0)
        @foreach ($listItems as $key => $item)
            {!!$item->name_content!!}
            <div id="load_kq_3d_{{$key}}">
                {!!$item->content!!}
            </div>
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
@section('jsl')
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/jquery.3.4.1.min.js') }}"></script>
@endsection
@section('js')
<script>
    var initToggleBackground = function(t, e) {
        t || (t = ".firstlast-mb td:not(first-child),.kqmb .number span,#result-book-content .kqmb td.number, .firstlast-mn td:not(first-child),.two-city td:not(.txt-giai) div, .three-city td:not(.txt-giai) div, .four-city td:not(.txt-giai) div"),
        e || (e = "bg-orange"),
        $(t).on("click", function() {
            $(this).toggleClass(e)
        })
    }
    initToggleBackground();
</script>
@endsection