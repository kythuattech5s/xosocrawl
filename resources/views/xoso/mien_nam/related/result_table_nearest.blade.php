<div class="box">
    @include('xoso.breadcrumbs.base')
    <div id="load_kq_tinh_1">
        @include('xoso.mien_nam.result_table')
        @include('xoso.mien_nam.head_tail')
        <div class="clearfix"></div>
    </div>
    @if (isset($viewRelate))
        @include('xoso.mien_bac.related.' . $viewRelate)
    @endif
</div>
