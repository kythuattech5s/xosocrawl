@extends('index')
@section('main')
    @include('partials.link_du_doan')
    <div class="box">
        <div class="bg_gray">
            <div class=" opt_date_full clearfix">
                @php
                    $prevLottoRecord = $lottoRecord->prev();
                    $nextLottoRecord = $lottoRecord->next();
                @endphp
                @if ($prevLottoRecord)
                    <a href="{{ $prevLottoRecord->link($linkPrefix) }}" class="ic-pre fl"
                        title="Kết quả xổ số {{ $prevLottoRecord->name }} ngày {{ Support::format($prevLottoRecord->created_at) }}"></a>
                @endif
                <label><strong>{{ Support::getDayOfWeek($lottoRecord->created_at) }}</strong> - <input type="text"
                        class="nobor hasDatepicker" value="{{ Support::format($lottoRecord->created_at) }}"
                        id="searchDate"><span class="ic ic-calendar"></span></label>
                @if ($nextLottoRecord)
                    <a href="{{ $nextLottoRecord->link($linkPrefix) }}" class="ic-next"
                        title="Kết quả xổ số {{ $nextLottoRecord->name }} ngày {{ Support::format($nextLottoRecord->created_at) }}"></a>
                @endif
            </div>
        </div>
    </div>

    <div class="box">
        @include('xoso.breadcrumbs.base')
        <div id="load_kq_tinh_0">
            @include('xoso.mien_bac.result_table_rolling')
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
            $prefixPath = $prefixPath ?? 'mien_bac';
            $pathSeeMore = $typeRelated ? 'see_more_' . $typeRelated : 'see_more';
            $viewSeemore = 'xoso.' . $prefixPath . '.' . $pathSeeMore;
        @endphp
        @if (View::exists($viewSeemore))
            @include($viewSeemore)
        @else
            @include('xoso.mien_bac.see_more')
        @endif
    </div>
    @php
    $viewRelated = 'xoso.' . $prefixPath . '.related.related_' . ($typeRelated ?? '');
    @endphp
    @if (View::exists($viewRelated))
        @include($viewRelated)
    @endif
@endsection
@section('js')
    <script src="theme/frontend/js/mien_bac.js" defer></script>
@endsection
