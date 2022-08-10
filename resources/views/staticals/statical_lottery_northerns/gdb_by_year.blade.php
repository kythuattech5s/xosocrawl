@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('statical_lottery_northerns', $currentItem)}}
@endsection
@section('main')
<div class="box">
    @include('staticals.statical_lottery_northerns.list_tab_panel',['activeId'=>$currentItem->id])
    <h2 class="tit-mien bold">Bảng đặc biệt miền Bắc theo năm</h2>
    <form id="statistic-form" class="form-horizontal" action="{{$currentItem->slug}}" method="post" accept-charset="utf8">
        @csrf
        <div class="form-group field-statisticform-year">
            <label class="control-label" for="statisticform-year">Chọn năm</label>
            <select id="statisticform-year" class="form-control" name="year">
                @for ($year = now()->year; $year >= 2002; $year--)
                    <option value="{{$year}}" {{$year == $activeYear ? 'selected':''}}>{{$year}}</option>
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
    <h3 class="tit-mien bold">Xem thống kê giải đặc biệt năm {{$activeYear}}</h3>
    <div class="box tong" style="overflow: auto;" id="monthly-result">
        <table>
            <tbody>
                <tr>
                    <th class="td-split">
                        <div>
                            <span class="top">Tháng</span>
                            <span class="bottom">Ngày</span>
                            <div class="line"></div>
                        </div>
                    </th>
                    @for ($month = 1; $month <= 12; $month++)
                        <th width="70px">{{$month}}</th>
                    @endfor
                </tr>
                @for ($day = 1; $day <= 31; $day++)
                    <tr>
                        <td>{{$day}}</td>
                        @for ($month = 1; $month <= 12; $month++)
                            @php
                                $code = $activeYear.($month < 10 ? '0'.$month:$month).($day < 10 ? '0'.$day:$day);
                            @endphp
                            <td>
                                @if (isset($arrItems[$code]))
                                    <div class="s14 bold"> {{substr($arrItems[$code]->number,0,3)}}<span class="clred">{{substr($arrItems[$code]->number,-2)}}</span> </div>
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