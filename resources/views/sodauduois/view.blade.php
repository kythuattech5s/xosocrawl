@php
    $dayOfWeekNameMap = [
        0 => 'Chủ nhật',
        1 => 'Thứ hai',
        2 => 'Thứ ba',
        3 => 'Thứ tư',
        4 => 'Thứ năm',
        5 => 'Thứ sáu',
        6 => 'Thứ bảy'
    ]
@endphp
@extends('index')
@section('breadcrumb')
{{Breadcrumbs::render('so_dau_duoi', $currentItem)}}
@endsection
@section('main')
<div class="box">
    <h2 class="tit-mien magb10">{{Support::show($currentItem,'short_name')}}</h2>
    @if ($currentItem->lotto_category_id == 1)
        <table class="l2d-table">
            <tbody>
                <tr class="head">
                    <th></th>
                    <th>Giải Bảy</th>
                    <th>Đặc Biệt</th>
                </tr>
                <tr></tr>
                @foreach ($listItems as $item)
                    @php
                        $listChild = $item->lottoResultDetails;
                        $gdbs = $listChild->where('no_prize',0);
                        $listG7 = $listChild->where('no_prize',7);
                        $strG7 = "";
                        foreach ($listG7 as $itemG7) {
                            $strG7 .= substr($itemG7->number,-2).', ';
                        }
                        $strG7 = trim($strG7,', ');
                    @endphp
                    <tr>
                        <td class="date">
                            {{$dayOfWeekNameMap[$item->created_at->dayOfWeek]}}, {{Support::showDateTime($item->created_at,'d/m/Y')}}
                        </td>
                        <td class="blue bold">{{$strG7}}</td>
                        <td class="blue">
                            @if (count($gdbs) > 0)
                                <i>{{substr($gdbs->first()->number,0,3)}}</i><i class="red">{{substr($gdbs->first()->number,-2)}}</i>
                            @endif
                        </td>
                    </tr>
                    <tr></tr>
                @endforeach
            </tbody>
        </table>
    @else
        <table class="l2d-table">
            <tbody>
                @foreach ($listItems as $item)
                    @if (isset($arrData[$item->fullcode]))
                        <tr>
                            <td class="date">
                                {{$dayOfWeekNameMap[$item->created_at->dayOfWeek]}}, {{Support::showDateTime($item->created_at,'d/m/Y')}}
                            </td>
                            @php
                                $count = 0;
                            @endphp
                            @foreach ($arrData[$item->fullcode] as $itemChild)
                                @php
                                    $gdbs = $itemChild->lottoResultDetails->where('no_prize',0)->first();
                                    $g8 = $itemChild->lottoResultDetails->where('no_prize',8)->first();
                                    $count++;
                                @endphp
                                <td>
                                    {{Support::show($itemChild->lottoItem,'name')}} <br>
                                    <b>{{substr($g8->number ?? '',0,2)}}</b>−<b class="red">{{substr($gdbs->number ?? '',-2)}}</b>
                                </td>
                            @endforeach
                            @if ($count < $numberTd)
                                @for ($i = 0; $i < $numberTd - $count; $i++)
                                    <td></td>
                                @endfor
                            @endif
                        </tr>
                        <tr></tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif
    {{ $listItems->withQueryString()->links('vendor.pagination.pagination_default') }}
    <div class="see-more">
        {!!Support::show($currentItem,'see_more')!!}
    </div>
</div>
<div class="box box-html">
    {!!Support::show($currentItem,'content')!!}
</div>
@endsection