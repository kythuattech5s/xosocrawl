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
                            $shortCodeDay = $item->created_at->day.'-'.$item->created_at->month.'-'.$item->created_at->year;
                            $nextItem = $item->nextResult ?? null;
                        @endphp
                        <td>
                            <a class="sub-title" href="xsmb-{{$shortCodeDay}}-ket-qua-xo-so-mien-bac-ngay-{{$shortCodeDay}}" title="XSMB {{$shortCodeDay}}">{{Support::showDateTime($item->created_at,'d-m-Y')}}</a>
                        </td>
                        <td>
                            <div class="statistic_lo bold">{{substr($item->number,0,3)}} <span class="clnote">{{substr($item->number,-2)}}</span></div>
                        </td>
                        <td>
                            @if (isset($nextItem))
                                <div class="statistic_lo bold">{{substr($nextItem->number,0,3)}} <span class="clnote">{{substr($nextItem->number,-2)}}</span></div>
                            @else
                                <div class="statistic_lo bold"><span class="clnote">-</span></div>
                            @endif
                        </td>
                        <td>
                            @php
                                $shortCodeNextDay = $item->created_at->addDays(1)->day.'-'.$item->created_at->addDays(1)->month.'-'.$item->created_at->addDays(1)->year;
                            @endphp
                            @if (isset($nextItem))
                                <a class="sub-title" href="xsmb-{{$shortCodeNextDay}}-ket-qua-xo-so-mien-bac-ngay-{{$shortCodeNextDay}}" title="XSMB {{$shortCodeNextDay}}">{{Support::showDateTime($nextItem->created_at,'d-m-Y')}}</a>
                            @else
                                <a class="sub-title" href="xsmb-{{$shortCodeNextDay}}-ket-qua-xo-so-mien-bac-ngay-{{$shortCodeNextDay}}" title="XSMB {{$shortCodeNextDay}}">{{$item->created_at->addDays(1)->format('d-m-Y')}}</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="de-ve-{{$haiSoCuoiGdb}}" class="btn-see-more magb10 txt-center" title="Đề về {{$haiSoCuoiGdb}}">Xem thêm</a>
    <div class="box box-note">
        <div class=" see-more ">
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
                {{-- @foreach (array_chunk(arrFrequency()) as $item)
                    
                @endforeach --}}
                <tr>
                    <td><span class="clred bold">84</span> - 4 lần</td>
                    <td><span class="clred bold">67</span> - 3 lần</td>
                    <td><span class="clred bold">85</span> - 2 lần</td>
                    <td><span class="clred bold">98</span> - 2 lần</td>
                    <td><span class="clred bold">65</span> - 2 lần</td>
                </tr>
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