@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('vietlott_child','Xổ số Keno',$currentItem->slug)}}
@endsection
@section('main')
<div class="keno">
    <div class="results">
        @foreach ($listItems as $key => $item)
            <div class="box">
                {!!$item->name_content!!}
                {!!str_replace('load_kq_keno','load_kq_keno_'.$key,$item->content)!!}
            </div>
        @endforeach
    </div>
    <div class="magb10">
        {{ $listItems->withQueryString()->links('vendor.pagination.pagination_default') }}
    </div>
</div>
<div class="box box-html">
    {!!$currentItem->content!!}
</div>
@endsection
@section('jsl')
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/jquery.3.4.1.min.js') }}"></script>
@endsection
@section('js')
    <script>
        $('.nav-tabs > li > a').click(function(event){
            event.preventDefault();

            var containerId = $(this).parent().parent().attr('aria-id');
            var active_tab_selector = $('#' + containerId + ' .nav-tabs > li.active > a').attr('href');

            console.log(containerId);
            console.log(active_tab_selector);
            $('#' + containerId + ' .nav-tabs > li.active').removeClass('active');
            $(this).parents('li').addClass('active');

            $(active_tab_selector).removeClass('active');
            $($(this).attr('href')).addClass('active');
            return false;
        });
    </script>
@endsection