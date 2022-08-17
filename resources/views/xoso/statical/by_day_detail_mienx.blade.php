@extends('index')
@section('main')
    <style>
        td.giai {
            display: flex;
            flex-wrap: wrap;
        }

        td.giai strong {
            padding: 1px;

        }

        td.giai5 strong,
        td.giai6 strong {
            min-width: 33.333%;
            text-align: center;
        }

        td.giai3 strong {
            min-width: 50%;
        }

        td.giai0 strong,
        td.giai1 strong,
        td.giai2 strong,
        td.giai5 strong,
        td.giai7 strong,
        td.giai8 strong {
            min-width: 100%;
        }

        td.giai4 strong {
            min-width: 25%;
            justify-content: center;
        }
    </style>
    <div id="result-book">
        <div class="box">
            <div class="txt-center clearfix ">
                <h2 class="tit-mien"><strong>
                        {{ $currentItem->time_name }}
                    </strong></h2>
                <form id="statistic-form" class="form-horizontal filter clearfix" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" value="{{ $currentItem->id }}" name="provinceId">
                        <label class="control-label">Hiển thị</label>
                        <div class="form-control" style="    text-align: left;">
                            <span class="radio"><label><input type="radio" name="type" value="0"
                                        {{ $numResultType == 0 ? 'checked' : '' }}>
                                    Đầy đủ</label></span>
                            <span class="radio"><label><input type="radio" name="type" value="2"
                                        {{ $numResultType == 2 ? 'checked' : '' }}> 2
                                    số</label></span>
                            <span class="radio"><label><input type="radio" name="type" value="3"
                                        {{ $numResultType == 3 ? 'checked' : '' }}> 3
                                    số</label></span>
                        </div>
                    </div>
                    <div class="txt-center">
                        <button class="btn btn-danger" type="submit">Xem</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="box" id="result-box-content">
            @foreach ($staticals as $lottoRecord)
                <div class="three-city clearfix">
                    <div data-id="kq" class="sub-col-l">

                        <table class="kqmb">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="13" class="bold"><a class="title-a" href="{{ $lottoCategory->slug }}"
                                            title="{{ $lottoCategory->short_name }}">{{ $lottoCategory->short_name }}</a> »
                                        <a class="title-a" href="{{ $lottoRecord->lottoItem->getSlug() }}"
                                            title="{{ $lottoRecord->lottoItem->short_name }}">{{ $lottoRecord->lottoItem->short_name }}</a>
                                        » <a class="title-a"
                                            href="{{ $lottoRecord->link($lottoCategory->prefix_sub_link) }}"
                                            title="{{ $lottoRecord->lottoItem->short_name }} {{ $lottoRecord->created_at->format('d-m-Y') }}">{{ $lottoRecord->lottoItem->short_name }}
                                            {{ $lottoRecord->created_at->format('d-m-Y') }}</a>
                                    </th>
                                </tr>
                                @foreach ($lottoRecord->lottoResultDetails->groupBy('no_prize') as $no => $details)
                                    <tr class="{{ \Lotto\Enums\NoPrize::getClassTr($no, $prefixPath ?? '') }}">
                                        <td class="txt-giai">{{ $no == 0 ? 'ĐB' : 'G' . $no }}</td>
                                        <td colspan="12" class="number giai giai{{ $no }}">
                                            @foreach ($details as $idx => $detail)
                                                <strong>{{ substr($detail->number, -$numResultType) }}</strong>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div data-id="dd" class="sub-col-r">
                        <table class="firstlast-mb fl">
                            <tbody>
                                <tr class="header">
                                    <th>Đầu</th>
                                    <th>Đuôi</th>
                                </tr>
                                @foreach ($lottoRecord->headTail()->getHeads() as $key => $numbers)
                                    <tr>
                                        <td><strong class="clnote">{{ $key }}</strong></td>
                                        <td>{!! implode(
                                            ', ',
                                            array_map(function ($number) {
                                                return $number->isSpecial() ? '<span class="clnote">' . $number->getNumber() . '</span>' : $number->getNumber();
                                            }, $numbers),
                                        ) !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
            @endforeach
            @if ($nextPageUrl = $staticals->nextPageUrl())
                <div class="txt-center">
                    <button class="btn btn-danger" data-href="{{ $nextPageUrl }}" id="result-see-more"
                        value="Xem thêm">Xem
                        thêm</button>
                </div>
            @endif
        </div>

        <div class="box box-html">
            {!! $currentItem->content !!}
        </div>
    </div>
@endsection
@section('js')
    <script src="theme/frontend/js/num_result.js" defer></script>
@endsection
