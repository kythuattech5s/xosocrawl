@php
    use ModuleStatical\Helpers\ModuleStaticalHelper;
    use ModuleStatical\Gdbmb\ModuleStaticalGdbmb;
@endphp
@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('statical_lottery_northerns', $currentItem)}}
@endsection
@section('main')
@include('staticals.statical_lottery_northerns.list_tab_panel',['activeId'=>$currentItem->id])
<div class="box tbl-row-hover">
    <h3 class="tit-mien bold">2 số cuối giải ĐB về <span class="clnote">{{$haiSoCuoiGdb}}</span>, xem bảng thống kê đặc biệt có thể về ngày mai</h3>
    <div class="clearfix">
        <table class="mag0 fl">
            <tbody>
                <tr>
                    <th>Ngày về</th>
                    <th>ĐB</th>
                    <th>ĐB hôm sau</th>
                    <th>Hôm sau</th>
                </tr>
                @foreach ($listSameDuoiGdb as $item)
                    <tr>
                        @php
                            $itemTime = ModuleStaticalHelper::parseStringToTime($item['lotto_record']['created_at']);
                            $shortCodeDay = Support::createShortCodeDay($itemTime);
                            $nextItem = $item['nextResult'] ?? null;
                        @endphp
                        <td>
                            <a class="sub-title" href="xsmb-{{$shortCodeDay}}-ket-qua-xo-so-mien-bac-ngay-{{$shortCodeDay}}" title="XSMB {{Support::showDateTime($itemTime)}}">{{Support::showDateTime($itemTime)}}</a>
                        </td>
                        <td>
                            <div class="statistic_lo bold">{{substr($item['number'],0,3)}} <span class="clnote">{{substr($item['number'],-2)}}</span></div>
                        </td>
                        <td>
                            @if (isset($nextItem))
                                <div class="statistic_lo bold">{{substr($nextItem['number'],0,3)}} <span class="clnote">{{substr($nextItem['number'],-2)}}</span></div>
                            @else
                                <div class="statistic_lo bold"><span class="clnote">-</span></div>
                            @endif
                        </td>
                        <td>
                            @php
                                $nextItemTime = isset($nextItem) ? ModuleStaticalHelper::parseStringToTime($nextItem['lotto_record']['created_at']):$itemTime->addDays(1);
                                $shortCodeNextDay = Support::createShortCodeDay($nextItemTime);
                            @endphp
                            <a class="sub-title" href="xsmb-{{$shortCodeNextDay}}-ket-qua-xo-so-mien-bac-ngay-{{$shortCodeNextDay}}" title="XSMB {{Support::showDateTime($nextItemTime,'d-m-Y')}}">{{Support::showDateTime($nextItemTime,'d-m-Y')}}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="de-ve-{{$haiSoCuoiGdb}}" class="btn-see-more magb10 txt-center" title="Đề về {{$haiSoCuoiGdb}}">Xem thêm</a>
    <div class="box box-note">
        <div class="see-more">
            <ul class="list-html-link two-column">
                @foreach (Support::extractJson($currentItem->related_link) as $itemSeeMore)
                    <li>{{Support::show($itemSeeMore,'name')}} <a href="{{Support::show($itemSeeMore,'link')}}" title="{{Support::show($itemSeeMore,'title')}}">{{Support::show($itemSeeMore,'title')}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="box tbl-row-hover">
    <h3 class="tit-mien bold">Thống kê tần suất 2 số cuối giải ĐB hôm sau khi đề hôm trước về <span class="clnote bold">{{$haiSoCuoiGdb}}</span></h3>
    <div class="clearfix">
        <table class="mag0 fl">
            <tbody>
                <tr>
                    <th>Bộ số</th>
                    <th>Bộ số</th>
                    <th>Bộ số</th>
                    <th>Bộ số</th>
                    <th>Bộ số</th>
                </tr>
                @foreach (array_chunk($arrFrequency,5,true) as $itemFrequency)
                    <tr>
                        @foreach ($itemFrequency as $key => $item)
                            <td><span class="clred bold">{{$key}}</span> - {{$item}} lần</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="box tbl-row-hover statistic-cham">
    <h3 class="tit-mien bold">Thống kê chạm những hôm về <span class="clnote bold">21</span></h3>
    <div class="clearfix">
        <table class="mag0 fl">
            <tbody>
                <tr>
                    <th>Bộ số</th>
                    <th>Đã về - <span class="clred">Đầu</span></th>
                    <th>Đã về - <span class="clred">Đuôi</span></th>
                    <th>Đã về - <span class="clred">Tổng</span></th>
                </tr>
                @for ($i = 0; $i <= 9; $i++)
                    <tr>
                        <td>{{$i}}</td>
                        <td><span class="clred">{{$arrLotteryTouch['dau'][$i] ?? 0}}</span> lần</td>
                        <td><span class="clred">{{$arrLotteryTouch['duoi'][$i] ?? 0}}</span> lần</td>
                        <td><span class="clred">{{$arrLotteryTouch['tong'][$i] ?? 0}}</span> lần</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
<div class="box tbl-row-hover">
    <h2 class="tit-mien bold">2 số cuối đặc biệt (đề gan lì) Miền Bắc lâu chưa về nhất</h2>
    <ul class="list-unstyle list-dau-db clearfix">
        @foreach ($topLoGanMb as $item)
            <li>
                <a href="de-ve-{{$item['duoigdb']}}" title="Đề về {{$item['duoigdb']}}" class="statistic_lo">{{$item['duoigdb']}}</a>: <span class="clnote">{{ModuleStaticalHelper::parseStringToTime($item['max_time'])->startOfDay()->diff(ModuleStaticalGdbmb::getGdbTime()->startOfDay())->days}} ngày</span>
            </li>
        @endforeach
    </ul>
</div>
<div class="box tbl-row-hover">
    <h2 class="tit-mien bold">Thống kê đầu GĐB Miền Bắc lâu chưa về ra nhất</h2>
    <div>
        <table class="mag0">
            <tbody>
                <tr>
                    <th>Đầu số</th>
                    <th>Ngày ra gần đây</th>
                    <th>Số ngày gan</th>
                </tr>
                @foreach ($topLoGanDauMb as $item)
                    @php
                        $maxTime = ModuleStaticalHelper::parseStringToTime($item['max_time']);
                        $shortCodeDay = Support::createShortCodeDay($maxTime);
                    @endphp
                    <tr>
                        <td class="s18 bold">{{$item['dau']}}</td>
                        <td><a class="sub-title" href="xsmb-{{$shortCodeDay}}-ket-qua-xo-so-mien-bac-ngay-{{$shortCodeDay}}" title="xổ số Miền Bắc ngày {{Support::showDateTime($maxTime,'d-m-Y')}}">{{Support::showDateTime($maxTime,'d-m-Y')}}</a></td>
                        <td class="s18 clred bold">{{$maxTime->startOfDay()->diff(ModuleStaticalGdbmb::getGdbTime()->startOfDay())->days}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="box tbl-row-hover">
    <h2 class="tit-mien bold">Thống kê đuôi GĐB Miền Bắc lâu chưa về ra nhất</h2>
    <div>
        <table class="mag0">
            <tbody>
                <tr>
                    <th>Đuôi số</th>
                    <th>Ngày ra gần đây</th>
                    <th>Số ngày gan</th>
                </tr>
                @foreach ($topLoGanDuoiMb as $item)
                    @php
                        $maxTime = ModuleStaticalHelper::parseStringToTime($item['max_time']);
                        $shortCodeDay = Support::createShortCodeDay($maxTime);
                    @endphp
                    <tr>
                        <td class="s18 bold">{{$item['duoi']}}</td>
                        <td><a class="sub-title" href="xsmb-{{$shortCodeDay}}-ket-qua-xo-so-mien-bac-ngay-{{$shortCodeDay}}" title="xổ số Miền Bắc ngày {{Support::showDateTime($maxTime,'d-m-Y')}}">{{Support::showDateTime($maxTime,'d-m-Y')}}</a></td>
                        <td class="s18 clred bold">{{$maxTime->startOfDay()->diff(ModuleStaticalGdbmb::getGdbTime()->startOfDay())->days}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="box tbl-row-hover">
    <h2 class="tit-mien bold">Thống kê giải đặc biệt Miền Bắc ngày này năm xưa</h2>
    <div>
        <table class="mag0">
            <tbody>
                <tr>
                    <th>Năm</th>
                    <th>Ngày</th>
                    <th>Giải đặc biệt</th>
                </tr>
                @foreach ($listToDayPastYear as $item)
                    @php
                        $shortCodeDay = Support::createShortCodeDay($item->lottoRecord->created_at);
                    @endphp
                    <tr>
                        <td class="s18 bold">{{$item->lottoRecord->created_at->year}}</td>
                        <td><a class="sub-title" href="xsmb-{{$shortCodeDay}}-ket-qua-xo-so-mien-bac-ngay-{{$shortCodeDay}}" title="xổ số Miền Bắc ngày {{Support::showDateTime($item->lottoRecord->created_at,'d-m-Y')}}">{{Support::showDateTime($item->lottoRecord->created_at,'d-m-Y')}}</a></td>
                        <td class="s18 clred bold">{{$item->number}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="box box-news">
    <a href="dien-dan-xo-so" title="Thảo luận kết quả xổ số">
        <h3 class="tit-mien bold">Thảo luận kết quả xổ số</h3>
    </a>
</div>
<div class="box tbl-row-hover">
    <h3 class="tit-mien bold">Thảo luận</h3>
    <div id="comment" class="fb-comments" data-href="{{url()->to($currentItem->slug)}}" data-width="100%" data-numposts="5"></div>
</div>
<div class="box box-html">
    {!!Support::show($currentItem,'content')!!}
</div>
@endsection