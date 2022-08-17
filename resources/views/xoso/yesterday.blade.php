@extends('index')
@section('main')
    @include('partials.link_du_doan')
    <ul class="tab-panel">
        @php
            $viewPanel = 'xoso.' . $viewPath . '.tab.panel_' . ($typeRelated ?? '');
        @endphp
        @if (View::exists($viewPanel))
            @include($viewPanel)
        @endif
    </ul>
    <div class="box">
        @php
            $viewBreadcrumb = 'xoso.breadcrumbs.' . $viewPath . '_' . ($typeRelated ?? '');
        @endphp
        @if (View::exists($viewBreadcrumb))
            @include($viewBreadcrumb)
        @endif
        <div id="load_kq_tinh_0">
            @php
                $viewResultTable = 'xoso.' . ($viewPath == 'mien_bac' ? '' : $viewPath) . '.result_table';
            @endphp
            @if (View::exists($viewResultTable))
                @include($viewResultTable)
            @endif
            <div class="txt-center">
                <div class="center">
                    @include('xoso.ads.banner_between_result_table')
                </div>
            </div>
            @php
                $viewHeadTail = 'xoso.' . ($viewPath == 'mien_bac' ? '' : $viewPath) . '.head_tail';
            @endphp
            @if (View::exists($viewHeadTail))
                @include($viewHeadTail)
            @endif
            <div class="clearfix"></div>
            <div class="bg_brown clearfix">
                <a rel="nofollow" class="conect_out " title="In vé dò" href="in-ve-do">In
                    vé dò</a>
            </div>
        </div>
        @php
            $viewSeeMore = 'xoso.yesterday.' . $viewPath . '_seemore';
        @endphp
        @if (View::exists($viewSeeMore))
            @include($viewSeeMore)
        @endif

        @php
            $viewRelated = 'xoso.yesterday.' . $viewPath . '_related';
        @endphp
        @if (View::exists($viewRelated))
            @include($viewRelated)
        @endif

    </div>
    <div class="box box-html s-content">
        {!! $currentItem->content !!}
    </div>
@endsection
