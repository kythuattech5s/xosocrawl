@extends('index')
@section('main')
    <div class="box" id="result-book">
        <h2 class="tit-mien"><strong>
                <span>Kết quả xổ số miền Trung</span> 1 tháng qua
            </strong></h2>
        <form id="statistic-form" class="form-horizontal clearfix" method="post">
            @csrf
            <div class="form-group field-statisticform-provinceid">
                <label class="control-label" for="statisticform-provinceid">Tỉnh</label>
                <select id="statisticform-provinceid" class="form-control" name="provinceId">
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                    @endforeach
                </select>
                <div class="help-block"></div>
            </div>
            <div class="form-group">
                <label class="control-label">Hiển thị</label>
                <div class="form-control">
                    <span class="radio"><label><input type="radio" name="type" value="0" checked=""> Đầy
                            đủ</label></span>
                    <span class="radio"><label><input type="radio" name="type" value="2"> 2
                            số</label></span>
                    <span class="radio"><label><input type="radio" name="type" value="3"> 3
                            số</label></span>
                </div>
            </div>
            <div class="txt-center">
                <button class="btn btn-danger" type="submit">Xem</button>
            </div>
        </form>
    </div>
    <div class="box" id="result-box-content">
        @foreach ($staticals as $record)
            @php
                $lottoItemMnCollection = $record->toLottoItemMnCollection();
            @endphp
            <div class="box">
                @include('xoso.breadcrumbs.mien_nam_dmY', ['lottoRecord' => $record])
                <div id="load_kq_mt_0">
                    @include('xoso.mien_nam.result_table', [
                        'lottoItemMnCollection' => $lottoItemMnCollection,
                    ])
                    <div class="txt-center">
                        <div class="center">
                            @include('xoso.ads.banner_between_result_table')
                        </div>
                    </div>
                    @include('xoso.mien_nam.head_tail')
                    <div class="clearfix"></div>
                    <div class="bg_brown clearfix">
                        <a rel="nofollow" class="conect_out " title="In vé dò" href="in-ve-do">In
                            vé dò</a>
                    </div>
                </div>
            </div>
        @endforeach
        @if ($nextPageUrl = $staticals->nextPageUrl())
            <div class="txt-center">
                <button class="btn btn-danger" data-href="{{ $nextPageUrl }}" id="result-see-more" value="Xem thêm">Xem
                    thêm</button>
            </div>
        @endif
    </div>
    <div class="box">
        @php
            $viewSeeMore = 'xoso.statical.' . $lottoCategory->view_path . '_seemore';
        @endphp
        @if (View::exists($viewSeeMore))
            @include($viewSeeMore)
        @endif
    </div>
    <div class="box box-html">
        {!! $currentItem->content !!}
    </div>
@endsection
@section('js')
    <script src="theme/frontend/js/num_result.js" defer></script>
@endsection
