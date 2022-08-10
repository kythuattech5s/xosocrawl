@php
    $maxDayOfMonth = [
        1 => 31,
        2 => 29,
        3 => 31,
        4 => 30,
        5 => 31,
        6 => 30,
        7 => 31,
        8 => 31,
        9 => 30,
        10 => 31,
        11 => 30,
        12 => 31
    ]
@endphp
@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('statical_lottery_northerns', $currentItem)}}
@endsection
@section('main')
<div class="box">
    @include('staticals.statical_lottery_northerns.list_tab_panel',['activeId'=>$currentItem->id])
    <h2 class="tit-mien bold">Bảng đặc biệt miền Bắc theo tháng</h2>
    <form id="statistic-form" class="form-horizontal" action="{{$currentItem->slug}}" method="post" accept-charset="utf8">
        @csrf
        <div class="form-group field-statisticform-month">
            <label class="control-label" for="statisticform-month">Chọn tháng</label>
            <select id="statisticform-month" class="form-control" name="month">
                @for ($month = 1; $month <= 12; $month++)
                    <option value="{{$month}}" {{$month == $activeMonth ? 'selected':''}}>{{$month}}</option>
                @endfor
            </select>
            <div class="help-block"></div>
        </div>
        <div class="txt-center">
            <button class="btn btn-danger" type="submit"><strong>Xem kết quả</strong></button>
        </div>
    </form>
</div>
<div class="box tbl-row-hover db-by-month">
    <h3 class="tit-mien bold">Xem thống kê giải đặc biệt tháng {{$activeMonth}}</h3>
    <div class="box tong" style="overflow: auto;" id="monthly-result">
        <table>
            <tbody>
                <tr>
                    <th class="td-split">
                        <div>
                            <span class="bottom">Năm</span>
                            <span class="top">Ngày</span>
                            <div class="line"></div>
                        </div>
                    </th>
                    @for ($day = 1; $day <= $maxDayOfMonth[$activeMonth]; $day++)
                        <th>{{$day}}</th>
                    @endfor
                </tr>
                @for ($year = now()->year; $year >= 2002; $year--)
                    <tr>
                        <td>{{$year}}</td>
                        @for ($day = 1; $day <= $maxDayOfMonth[$activeMonth]; $day++)
                            @php
                                $code = $year.($activeMonth < 10 ? '0'.$activeMonth:$activeMonth).($day < 10 ? '0'.$day:$day);
                            @endphp
                            <td>
                                @if (isset($arrItems[$code]))
                                    <div class="s16 bold"> {{substr($arrItems[$code]->number,0,3)}}<span class="clred">{{substr($arrItems[$code]->number,-2)}}</span> </div>
                                @endif
                            </td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
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
    <h3 class="tit-mien bold">Thảo luận</h3>
    <div id="comment" class="fb-comments" data-href="{{url()->to($currentItem->slug)}}" data-width="100%" data-numposts="5"></div>
</div>
<div class="box box-html">
    {!!Support::show($currentItem,'content')!!}
</div>
@endsection