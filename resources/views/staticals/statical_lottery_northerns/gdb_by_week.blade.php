@php
    use ModuleStatical\Helpers\ModuleStaticalHelper;
@endphp
@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('statical_lottery_northerns', $currentItem)}}
@endsection
@section('main')
<div class="box tbl-row-hover">
    @include('staticals.statical_lottery_northerns.list_tab_panel',['activeId'=>$currentItem->id])
    <h2 class="tit-mien bold">Bảng đặc biệt miền Bắc theo tuần từ {{Support::showDateTime(,'name')}} đến 09-08-2022</h2>
    <div class="box tong" id="monthly-result">
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
                    $currentTime = $timeStart;
                    $startAddDay = false;
                    $count = 0;
                @endphp
                @while ($currentTime->lt($timeEnd))
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
                                        <div class="s14 bold">{{substr($item->number,0,3)}}<span class="clred">{{substr($item->number,3,2)}}</span> </div>
                                        <div style="font-size: small;color: gray">{{Support::createShortCodeDay($item->created_at)}}</div>
                                    @else
                                        @if ($currentTime->lt($timeEnd))
                                            <div class="s14 bold">-</div>
                                            <div style="font-size: small;color: gray">{{Support::createShortCodeDay($currentTime)}}</div>
                                        @endif
                                    @endif
                                @endif
                                @php
                                    if ($startAddDay) {
                                        $currentTime->addDays(1);
                                    }
                                @endphp
                            </td>
                        @endfor
                    </tr>
                @endwhile
                
            </tbody>
        </table>
    </div>
    <div class="box box-note">
        <div class="see-more ">
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