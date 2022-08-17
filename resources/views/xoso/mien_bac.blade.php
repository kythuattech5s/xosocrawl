@extends('index')
@section('main')
    @include('partials.link_du_doan')
    <div class="box">
        <div class="bg_gray">
            <div class=" opt_date_full clearfix">
                @if (isset($linkFormat))
                    @php
                        $prevLottoRecord = $lottoRecord->prev(false);
                        $nextLottoRecord = $lottoRecord->next(false);
                    @endphp
                    @if ($prevLottoRecord)
                        <a href="{{ $prevLottoRecord->linkWithFormat($linkFormat) }}" class="ic-pre fl"
                            title="Kết quả xổ số {{ $prevLottoRecord->name }} ngày {{ Support::format($prevLottoRecord->created_at) }}"></a>
                    @endif
                @endif
                <label><strong>{{ Support::getDayTextFullOfWeek($lottoRecord->created_at) }}</strong> - <input type="text"
                        class="nobor hasDatepicker" value="{{ Support::format($lottoRecord->created_at) }}"
                        id="searchDate"><span class="ic ic-calendar"></span></label>
                @if (isset($linkFormat))
                    @if ($nextLottoRecord)
                        <a href="{{ $nextLottoRecord->linkWithFormat($linkFormat) }}" class="ic-next"
                            title="Kết quả xổ số {{ $nextLottoRecord->name }} ngày {{ Support::format($nextLottoRecord->created_at) }}"></a>
                    @endif
                @endif


            </div>
        </div>
    </div>
    <ul class="tab-panel">
        @php
            $viewPanel = 'xoso.mien_bac.tab.panel_' . ($typeRelated ?? '');
        @endphp
        @if (View::exists($viewPanel))
            @include($viewPanel)
        @endif
    </ul>
    <div class="box">
        @php
            $viewBreadcrumb = 'xoso.breadcrumbs.mien_bac_' . ($typeRelated ?? '');
        @endphp
        @if (View::exists($viewBreadcrumb))
            @include($viewBreadcrumb)
        @endif
        <div id="load_kq_tinh_0">
            @include('xoso.result_table')
            <div class="txt-center">
                <div class="center">
                    @include('xoso.ads.banner_between_result_table')
                </div>
            </div>
            @include('xoso.head_tail')
            <div class="clearfix"></div>
            <div class="bg_brown clearfix">
                <a rel="nofollow" class="conect_out " title="In vé dò" href="in-ve-do">In
                    vé dò</a>
            </div>
        </div>
        @php
            $viewCateNews = 'xoso.mien_bac.cate_news.cate_news_' . ($typeRelated ?? '');
            
        @endphp
        @if (View::exists($viewCateNews))
            @include($viewCateNews)
        @else
            @include('xoso.mien_bac.cate_news.cate_news')
        @endif

    </div>

    @php
    $viewRelated = 'xoso.mien_bac.related.related_' . ($typeRelated ?? '');
    @endphp
    @if (View::exists($viewRelated))
        @include($viewRelated)
    @endif

@endsection
@section('js')
    <script src="theme/frontend/js/mien_bac.js" defer></script>
@endsection
