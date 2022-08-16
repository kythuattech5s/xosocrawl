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

        td.giai3 strong,
        td.giai5 strong,
        td.giai6 strong {
            min-width: 33.333%;
            text-align: center;
        }

        td.giai2 strong {
            min-width: 50%;
        }

        td.giai0 strong,
        td.giai1 strong {
            min-width: 100%;
        }

        td.giai4 strong,
        td.giai7 strong {
            min-width: 25%;
        }
    </style>
    <div id="result-book">
        <div class="box">
            <div class="txt-center clearfix ">
                <h2 class="tit-mien"><strong>
                        <span>{{ $currentItem->name }}</span> 10 ngày qua
                    </strong></h2>
                <form id="statistic-form" class=" clearfix form-horizontal " method="post">
                    @csrf
                    <div class="form-group field-statisticform-numofday"><label class="control-label"
                            for="statisticform-numofday">Số ngày</label><select id="statisticform-numofday"
                            class="form-control" name="numOfDay">
                            @foreach ($staticalItems as $item)
                                <option value="{{ $item->num_day }}" {{ $numOfDay == $item->num_day ? 'selected' : '' }}>
                                    {{ $item->num_day }} ngày</option>
                            @endforeach
                        </select>
                        <div class="help-block"></div>
                    </div>
                    <div class="form-group"><button type="submit" class="btn-danger btn">Xem ngay</button></div>
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
                                    <th colspan="13">
                                        <h2 class="bold"><a class="title-a"
                                                href="{{ $lottoRecord->link($lottoCategory->prefix_sub_link) }}"
                                                title="{{ $lottoCategory->short_name }} ngày {{ $lottoRecord->created_at->format('d-m-Y') }}">{{ $lottoCategory->short_name }}
                                                ngày {{ $lottoRecord->created_at->format('d-m-Y') }}</a></h2>
                                    </th>
                                </tr>
                                @foreach ($lottoRecord->lottoResultDetails->groupBy('no_prize') as $no => $details)
                                    <tr class="{{ \Lotto\Enums\NoPrize::getClassTr($no, $prefixPath ?? '') }}">
                                        <td class="txt-giai">{{ $no == 0 ? 'ĐB' : 'G' . $no }}</td>
                                        <td colspan="12" class="number giai giai{{ $no }}">
                                            @foreach ($details as $idx => $detail)
                                                <strong>{{ $detail->number }}</strong>
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
        </div>
        <div class="box clearfix">
            <h2 class="tit-mien bold">Thống kê giải bặc biệt {{ $numOfDay }} ngày về nhiều nhất</h2>
            <div class="clearfix">
                <table class="fl tbl50">
                    <tbody>
                        <tr>
                            <th>Bộ số</th>
                            <th>Số lượt về</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="bold"><span class="clred bold">13</span></div>
                            </td>
                            <td> về 3 lần</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="bold"><span class="clred bold">55</span></div>
                            </td>
                            <td> về 2 lần</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="bold"><span class="clred bold">93</span></div>
                            </td>
                            <td> về 2 lần</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="bold"><span class="clred bold">02</span></div>
                            </td>
                            <td> về 1 lần</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="bold"><span class="clred bold">03</span></div>
                            </td>
                            <td> về 1 lần</td>
                        </tr>
                    </tbody>
                </table>
                <table class="fl tbl50">
                    <tbody>
                        <tr>
                            <th>Bộ số</th>
                            <th>Số lượt về</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="bold"><span class="clred bold">04</span></div>
                            </td>
                            <td> về 1 lần</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="bold"><span class="clred bold">06</span></div>
                            </td>
                            <td> về 1 lần</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="bold"><span class="clred bold">09</span></div>
                            </td>
                            <td> về 1 lần</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="bold"><span class="clred bold">17</span></div>
                            </td>
                            <td> về 1 lần</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="bold"><span class="clred bold">19</span></div>
                            </td>
                            <td> về 1 lần</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h2 class="tit-mien bold">Thống kê 30 ngày đầu đuôi giải đặc biệt, tổng giải đặc biệt</h2>
            <table class="mag0">
                <tbody>
                    <tr>
                        <th>Đầu</th>
                        <th>Đuôi</th>
                        <th>Tổng</th>
                    </tr>
                    <tr>
                        <td> Đầu 0: <span class="clred">5</span> lần</td>
                        <td> Đuôi 0: <span class="clred">3</span> lần</td>
                        <td> Tổng 0: <span class="clred">5</span> lần</td>
                    </tr>
                    <tr>
                        <td> Đầu 1: <span class="clred">5</span> lần</td>
                        <td> Đuôi 1: <span class="clred">2</span> lần</td>
                        <td> Tổng 1: <span class="clred">1</span> lần</td>
                    </tr>
                    <tr>
                        <td> Đầu 2: <span class="clred">2</span> lần</td>
                        <td> Đuôi 2: <span class="clred">3</span> lần</td>
                        <td> Tổng 2: <span class="clred">4</span> lần</td>
                    </tr>
                    <tr>
                        <td> Đầu 3: <span class="clred">1</span> lần</td>
                        <td> Đuôi 3: <span class="clred">7</span> lần</td>
                        <td> Tổng 3: <span class="clred">4</span> lần</td>
                    </tr>
                    <tr>
                        <td> Đầu 4: <span class="clred">0</span> lần</td>
                        <td> Đuôi 4: <span class="clred">1</span> lần</td>
                        <td> Tổng 4: <span class="clred">6</span> lần</td>
                    </tr>
                    <tr>
                        <td> Đầu 5: <span class="clred">4</span> lần</td>
                        <td> Đuôi 5: <span class="clred">4</span> lần</td>
                        <td> Tổng 5: <span class="clred">1</span> lần</td>
                    </tr>
                    <tr>
                        <td> Đầu 6: <span class="clred">2</span> lần</td>
                        <td> Đuôi 6: <span class="clred">3</span> lần</td>
                        <td> Tổng 6: <span class="clred">1</span> lần</td>
                    </tr>
                    <tr>
                        <td> Đầu 7: <span class="clred">2</span> lần</td>
                        <td> Đuôi 7: <span class="clred">4</span> lần</td>
                        <td> Tổng 7: <span class="clred">2</span> lần</td>
                    </tr>
                    <tr>
                        <td> Đầu 8: <span class="clred">3</span> lần</td>
                        <td> Đuôi 8: <span class="clred">1</span> lần</td>
                        <td> Tổng 8: <span class="clred">3</span> lần</td>
                    </tr>
                    <tr>
                        <td> Đầu 9: <span class="clred">6</span> lần</td>
                        <td> Đuôi 9: <span class="clred">2</span> lần</td>
                        <td> Tổng 9: <span class="clred">3</span> lần</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
