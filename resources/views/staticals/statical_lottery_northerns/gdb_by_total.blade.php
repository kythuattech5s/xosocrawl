@php
    use ModuleStatical\Helpers\ModuleStaticalHelper;
@endphp
@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('statical_lottery_northerns', $currentItem)}}
@endsection
@section('css')
    <link rel="stylesheet" href="{{Support::asset('theme/frontend/css/daterangepicker.min.css')}}">
    <style>
        .glyphicon-calendar {
            background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAAOCAYAAAAfSC3RAAAAqklEQVQ4T6WSAQ2DQAxFHw6QgIThAAmTgAQkIAEJSJgEHGwSJgEJ5JG7jFzgBqFJE67l9V/bK/hZBzyAHvhu4n4aN/8BBgMF8AJKoALakJgT0LzgGIrOgiroT6AJYKpoUcEpCPVbMBHJHlfQKvoVa24pxh6PFB2MvTvEaKd6tHCcZhZUQXMlKrnDdXf/FAVV8Gf3qqeWvarw3iuyyKke94Z2D3TM7yvbB+oFcLYpL5aZM2YAAAAASUVORK5CYII=");
            background-size: contain;
            background-position: center;
            display: inline-block;
            width: 14px;
            height: 14px;
        }
        .fa {
            display: inline-block;
            font: normal normal normal 14px/1 FontAwesome;
            font-size: inherit;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .glyphicon {
            position: relative;
            top: 1px;
            display: inline-block;
            font-family: 'Glyphicons Halflings';
            font-style: normal;
            font-weight: 400;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .daterangepicker .calendar {
            display: none;
            max-width: 270px;
            min-width: 0;
            margin: 4px;
        }
        .daterangepicker td{
            font-size: inherit;
        }
        .daterangepicker th{
            background: none;
            margin: 0;
        }
        .daterangepicker * {
            box-sizing: border-box;
        }
        .daterangepicker table, .daterangepicker table td, .daterangepicker table th {
            border: none;
        }
        .btn-success {
            color: #fff;
            background-color: #5cb85c;
            border-color: #4cae4c;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .opensright {
            display: none;
        }
        .glyphicon-chevron-left {
            background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAAOCAYAAAAfSC3RAAAAYElEQVQ4T2NkIA4IMDAwfEBWykiEPpCmDQwMDAkMDAwPYOoJaYRpKmBgYLhArI04NYEMwGUjXk24NBLUhE0jUZqoqhFkGFG2UjVwYNFFVnQQ1Ewo5SD7maQkh2wzSiIHAP/IGg+3WqATAAAAAElFTkSuQmCC");
            background-size: contain;
            background-position: center;
            display: inline-block;
            width: 14px;
            height: 14px;
        }
        .glyphicon-chevron-right {
            background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAAOCAYAAAAfSC3RAAAATUlEQVQ4T2NkIBMwkqmPAZfGAAYGhg34DMWl0YCBgSGBgYGhAJdmfE7Fq5mQH3FqJqQR5FKsmmmmkSynkhU4ZEcH2QmAYEokJlSxGgIAgOAKDxkkxIgAAAAASUVORK5CYII=");
            background-size: contain;
            background-position: center;
            display: inline-block;
            width: 14px;
            height: 14px;
        }
    </style>
@endsection
@section('main')
<div class="box tk-tong-db">
    @include('staticals.statical_lottery_northerns.list_tab_panel',['activeId'=>$currentItem->id])
    <div class="clearfix">
        <h2 class="tit-mien magb10"><strong>Bảng thống kê giải đặc biệt theo tổng </strong></h2>
        @if (!$valueValidate)
            <div class="txt-center clnote">{{$valueValidateMessage}}</div>
        @endif
        <form id="statistic-form" class=" clearfix form-horizontal" action="{{$currentItem->slug}}" method="post" accept-charset="utf8">
            @csrf
            <div class="form-group drp-container">
                <label>Chọn ngày</label>
                <input type="text" id="statisticform-fromdate" class="form-control" name="from_date" value="{{$fromDateValue}}"> 
            </div>
            <div class="form-group txt-center">
                <button type="submit" class="btn btn-danger">Xem kết quả</button>
            </div>
        </form>
    </div>
    <div class="pad10">Dữ liệu được xem trong khoảng 100 ngày gần đây nhất</div>
</div>
<div class="box tong" id="monthly-result">
    @if ($valueValidate)
        <div class="title-c2 pad10 txt-center">
            <div class="toogle-buttons">
                <span class="toggle-button">
                    <input type="checkbox" id="dau-toggle-input" data-class="dau" class="cbx dspnone">
                    <label class="lbl1" for="dau-toggle-input"></label>
                    <span>Đầu</span>
                </span>
                <span class="toggle-button">
                    <input type="checkbox" id="duoi-toggle-input" data-class="duoi" class="cbx dspnone">
                    <label class="lbl1" for="duoi-toggle-input"></label>
                    <span>Đuôi</span>
                </span>
                <span class="toggle-button">
                    <input type="checkbox" id="loto-toggle-input" data-class="loto" class="cbx dspnone">
                    <label class="lbl1" for="loto-toggle-input"></label>
                    <span>Loto</span>
                </span>
                <span class="toggle-button">
                    <input type="checkbox" id="tong-toggle-input" data-class="tong" checked="" class="cbx dspnone">
                    <label class="lbl1" for="tong-toggle-input"></label>
                    <span>Tổng</span>
                </span>
            </div>
        </div>
        <div class="tk-tong-db tk-db">
            <table>
                <tbody>
                    <tr>
                        <th>Thứ 2</th>
                        <th>Thứ 3</th>
                        <th>Thứ 4</th>
                        <th>Thứ 5</th>
                        <th>Thứ 6</th>
                        <th>Thứ 7</th>
                        <th>CN</th>
                    </tr>
                    @php
                        $currentTime = $startDate;
                        $startAddDay = false;
                        $count = 0;
                    @endphp
                    @while ($currentTime->lt($endDate))
                        <tr>
                            @for ($i = 1; $i <=7; $i++)
                                @php
                                    $dayOfWeek = $i < 7 ? $i:$i-7;
                                @endphp
                                    <td>
                                        @if ($currentTime->dayOfWeek == $dayOfWeek)
                                            @php
                                                $startAddDay = true;
                                                $item = $arrItems[ModuleStaticalHelper::timeToFullcode($currentTime)] ?? null;
                                            @endphp
                                            @if (isset($item))
                                                @php
                                                    $dau = substr(substr($item->number,-2),0,1);
                                                    $duoi = substr($item->number,-1);
                                                    $tong = ($dau+$duoi)%10;
                                                @endphp
                                                <div> {{substr($item->number,0,3)}}<span class="clblue">{{substr($item->number,-2)}}</span> </div>
                                                <div class="ngay-quay">{{Support::showDateTime($item->created_at,'d-m-Y')}}</div>
                                                <div class="clnote dau ">{{$dau}}</div>
                                                <div class="clnote duoi ">{{$duoi}}</div>
                                                <div class="clnote loto ">{{substr($item->number,-2)}}</div>
                                                <div class="clnote tong ">{{$tong}}</div>
                                            @endif
                                        @endif
                                        <span></span>
                                    </td>
                                @php
                                    if ($startAddDay) {
                                        $currentTime->addDays(1);
                                    }
                                @endphp
                            @endfor
                        </tr>
                    @endwhile
                </tbody>
            </table>
        </div>
    @endif
    <div class="see-more">
        <ul class="list-html-link two-column">
            @foreach (Support::extractJson($currentItem->related_link) as $itemSeeMore)
                <li>{{Support::show($itemSeeMore,'name')}} <a href="{{Support::show($itemSeeMore,'link')}}" title="{{Support::show($itemSeeMore,'title')}}">{{Support::show($itemSeeMore,'title')}}</a></li>
            @endforeach
        </ul>
    </div>
</div>
<div class="box box-html">
    {!!Support::show($currentItem,'content')!!}
</div>
<div class="box tbl-row-hover">
    <div id="comment" class="fb-comments" data-href="{{url()->to($currentItem->slug)}}" data-width="100%" data-numposts="5"></div>
</div>
@endsection
@section('jsl')
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/jquery.3.4.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/daterangepicker.min.js') }}"></script>
@endsection
@section('js')
<script>
    window.daterangepicker_45a4a0d3 = {"locale":{"format":"DD-MM-YYYY","applyLabel":"Apply","cancelLabel":"Cancel","fromLabel":"From","toLabel":"To","weekLabel":"W","customRangeLabel":"Custom Range","daysOfWeek":moment.weekdaysMin(),"monthNames":moment.monthsShort(),"firstDay":moment.localeData()._week.dow},"ranges":{"7 ngày qua":[moment().startOf('day').subtract(6, 'days'),moment()],"30 ngày qua":[moment().startOf('day').subtract(29, 'days'),moment()],"Tháng này":[moment().startOf('month'),moment().endOf('month')],"Tháng trước":[moment().subtract(1, 'month').startOf('month'),moment().subtract(1, 'month').endOf('month')]},"cancelButtonClasses":"btn-default","language":"vi","startDate":"01-07-2022","endDate":"31-07-2022","autoUpdateInput":false};
</script>
<script>
    $("#monthly-result .toggle-button input").on("click", function() {
        $("#monthly-result").toggleClass($(this).attr("data-class"));
    });
    jQuery(function ($) {
        jQuery("#statisticform-fromdate").off('change.kvdrp').on('change.kvdrp', function(e) {
            var drp = jQuery("#statisticform-fromdate").data('daterangepicker'), fm, to;
            if ($(this).val() || !drp) {
                return;
            }
            fm = moment().startOf('day').format('DD-MM-YYYY') || '';
            to = moment().format('DD-MM-YYYY') || '';
            drp.setStartDate(fm);
            drp.setEndDate(to);
        });
        jQuery&&jQuery.pjax&&(jQuery.pjax.defaults.maxCacheLength=0);
        if (jQuery('#statisticform-fromdate').data('daterangepicker')) { jQuery('#statisticform-fromdate').daterangepicker('destroy'); }
        jQuery("#statisticform-fromdate").daterangepicker(daterangepicker_45a4a0d3, function(start,end,label){var val=start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY');jQuery("#statisticform-fromdate").val(val).trigger('change');});
    });
</script>
@endsection