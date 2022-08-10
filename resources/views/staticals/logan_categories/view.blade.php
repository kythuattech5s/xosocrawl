@php
    use ModuleStatical\Helpers\ModuleStaticalHelper;
    use ModuleStatical\TrungNam\ModuleStaticalLoganTrungNam;
    $timeTrungNam = ModuleStaticalLoganTrungNam::getTime();
@endphp
@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('logan_categories', $currentItem)}}
@endsection
@section('main')
    @include('staticals.logan_categories.list_tab_panel',['activeId'=>$currentItem->id])
    <div class="box tbl-row-hover">
        <h2 class="tit-mien">
            <strong>Các bộ số lô gan {{Support::show($currentItem,'main_area_name')}} ngày hôm nay</strong>
        </h2>
        <form id="statistic-form" class="form-horizontal" action="{{Support::show($currentItem,'slug')}}" method="post" accept-charset="utf8">
            @csrf
            <div class="form-group field-statisticform-provinceid">
                <label class="control-label" for="statisticform-provinceid">Chọn tỉnh</label>
                <select id="statisticform-provinceid" class="form-control" name="province" onchange="document.querySelector('#statistic-form').submit()">
                    @foreach ($listLogan as $item)
                        <option value="{{Support::show($item,'province_code')}}">{{Support::show($item,'province_name')}}</option>
                    @endforeach
                </select>
                <div class="help-block"></div>
            </div>
            <div class="form-group field-statisticform-numofday">
                <label class="control-label" for="statisticform-numofday">Chọn biên độ</label>
                <select id="statisticform-numofday" class="form-control" name="num_of_day">
                    @for ($numOfDay = 2; $numOfDay <= 50; $numOfDay++)
                        <option value="{{$numOfDay}}" {{$activeNumOfDay == $numOfDay ? 'selected':''}}>{{$numOfDay}}</option>
                    @endfor
                </select>
                <div class="hint-block">(Số lần mở thưởng gần đây nhất)</div>
                <div class="help-block"></div>
            </div>
            <div class="txt-center">
                <button class="btn btn-danger" type="submit"><strong>Xem kết quả</strong></button>
            </div>
        </form>
    </div>
    <div class="box tbl-row-hover">
        @foreach ($listItemLoganActive as $itemLoganActive)
            <h2 class="tit-mien">Thống kê <a href="{{Support::show($itemLoganActive,'slug')}}" title="lô gan {{Support::show($itemLoganActive,'province_name')}}" class="title-a">lô gan {{Support::show($itemLoganActive,'province_name')}}</a> lâu chưa về nhất tính đến ngày hôm nay</h2>
            <div class="scoll">
                <table class="mag0">
                    <tbody>
                        <tr>
                            <th>Bộ số</th>
                            <th>Ngày ra gần đây</th>
                            <th>Số ngày gan</th>
                            <th>Gan cực đại</th>
                        </tr>
                        @foreach (ModuleStaticalLoganTrungNam::getTopGanByLoganItem($itemLoganActive,10) as $item)
                            @php
                                $maxTime = ModuleStaticalHelper::parseStringToTime($item->max_time);
                                $shortCodeDay = Support::createShortCodeDay($maxTime);
                            @endphp
                            <tr>
                                <td><strong>{{$item->duoi}}</strong></td>
                                <td><a class="sub-title bold" href="xsdn-{{$shortCodeDay}}-ket-qua-xo-so-dong-nai-ngay-{{$shortCodeDay}}-p11" title="xổ số Đồng Nai ngày {{Support::showDateTime($maxTime,'d-m-Y')}}">{{Support::showDateTime($maxTime,'d-m-Y')}}</a></td>
                                <td class="s18 clred bold">{{$item->dayGan}}</td>
                                <td class="s18 clred bold">27</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
        <div class="box see-more">
            <ul class="list-html-link">
                @foreach (Support::extractJson($currentItem->see_more_link) as $itemSeeMore)
                    <li>{{Support::show($itemSeeMore,'name')}} <a href="{{Support::show($itemSeeMore,'link')}}" title="{{Support::show($itemSeeMore,'title')}}">{{Support::show($itemSeeMore,'title')}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="box tbl-row-hover">
        <h3 class="tit-mien"><strong>Thảo luận</strong></h3>
        <div id="comment" class="fb-comments" data-href="{{url()->to($currentItem->slug)}}" data-width="100%" data-numposts="5"></div>
    </div>
    <div class="box box-html">
        {!!Support::show($currentItem,'content')!!}
    </div>
@endsection