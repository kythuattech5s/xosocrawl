<div class="box">
    @php
        $viewBreadcrumb = 'xoso.breadcrumbs.mien_bac_' . ($typeRelated ?? '');
    @endphp
    @if (View::exists($viewBreadcrumb))
        @include($viewBreadcrumb)
    @else
        @include('xoso.breadcrumbs.base')
    @endif
    <div id="load_kq_tinh_1">
        @include('xoso.result_table')
        @include('xoso.head_tail')
        <div class="clearfix"></div>
    </div>
    @if (isset($viewRelate))
        @include('xoso.mien_bac.related.' . $viewRelate)
    @endif
</div>
