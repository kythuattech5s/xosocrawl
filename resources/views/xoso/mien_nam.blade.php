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
            @include('xoso.mien_nam.result_table')
            <div class="txt-center">
                <div class="center">
                    <a class="ban-link" href="/redirect/out?token=I%2FZxoQFsuUjDev87POoC9PSveDZOsQOylNFoAc3oAoA%3D"
                        title="" rel="nofollow" target="_blank" data-pos="ban_square"><img
                            src="theme/frontend/images/tuvan.png"></a>
                </div>
            </div>
            @include('xoso.mien_nam.head_tail')
            <div class="clearfix"></div>
            <div class="bg_brown clearfix">
                <a rel="nofollow" class="conect_out " title="In vé dò" href="https://xoso.me/in-ve-do.html">In
                    vé dò</a>
            </div>
        </div>
        @php
            $viewCateNews = 'xoso.mien_nam.cate_news.cate_news_' . ($typeRelated ?? '');
            
        @endphp
        @if (View::exists($viewCateNews))
            @include($viewCateNews)
        @else
            @include('xoso.mien_nam.cate_news.cate_news')
        @endif

        <div class="see-more">
            <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm:</div>
            <ul class="list-html-link two-column">
                <li>Xem thống kê <a href="lo-gan-mn-thong-ke-lo-gan-mien-nam" title="lô gan miền Nam">lô gan miền Nam</a>
                </li>
                <li>Mời bạn <a href="quay-thu-xsmn-quay-thu-xo-so-mien-nam" title="quay thử miền Nam">quay thử miền Nam</a>
                    hôm nay để lấy hên</li>
                <li>Xem cao thủ <a href="du-doan-ket-qua-xo-so-mien-nam-xsmn-c226" title="dự đoán xổ số miền Nam">dự đoán xổ
                        số miền Nam</a> chính xác nhất</li>
                <li>Xem bảng kết quả <a href="xsmn-30-ngay-so-ket-qua-xo-so-kien-thiet-mien-nam"
                        title="XSMN 30 ngày gần nhất">XSMN 30 ngày gần nhất</a></li>
            </ul>
        </div>

    </div>

    @php
    $viewRelated = 'xoso.mien_nam.related.related_' . ($typeRelated ?? '');
    @endphp
    @if (View::exists($viewRelated))
        @include($viewRelated)
    @endif

@endsection
@section('js')
    <script src="theme/frontend/js/mien_bac.js" defer></script>
@endsection
