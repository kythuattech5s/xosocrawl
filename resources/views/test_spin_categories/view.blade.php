@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('test_spin_categories', $currentItem)}}
@endsection
@section('main')
<div class="box quay-thu">
    <ul class="tab-panel tab-auto">
        @foreach ($listItemTestSpinCategory as $item)
            <li class="{{$item->id == $currentItem->id ? 'active':''}}">
                <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'short_name')}}">{{Support::show($item,'short_name')}}</a>
            </li>
        @endforeach
    </ul>
    <div class="tit-mien clearfix">
        <h2>
            @if ($currentItem->id == 1)
                Quay thử {{Support::show($currentItem,'main_area_name')}} ngày {{now()->format('d-m-Y')}}
            @else
                Quay thử {{Support::show($currentItem,'main_area_name')}} ngày {{now()->format('d-m-Y')}}
            @endif
        </h2>
    </div>
    <div class="box" id="trial-box">
        <div class="txt-center bg-orange">
            <form id="trial_form" class="form-horizontal" action="{{Support::show($currentItem,'slug')}}" method="post" accept-charset="utf8">
                @csrf
                <div class="form-group">
                    <select id="province_name" name="province_name" onchange="document.getElementById('trial_form').submit();">
                        <option value="">Chọn đài quay thử</option>
                        @if ($currentItem->id == 1)
                            <option value="mien-bac" selected>Miền Bắc</option>
                        @endif
                        @foreach ($listItems as $item)
                            <option value="{{Support::show($item,'province_code')}}">{{Support::show($item,'province_name')}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group txt-center">
                    <button type="button" class="btn btn-danger trial-button" data-interval="3000">Bắt đầu quay</button>
                    <button type="button" class="btn btn-light trial-button" data-interval="500">Quay nhanh</button>
                </div>
                <div class="form-group txt-center">
                    Quay thử đài: 
                    @foreach ($listActiveTestSpinToday as $itemActiveTestSpinToday)
                        <a class="item_sublink mag-l5" href="{{Support::show($itemActiveTestSpinToday,'slug')}}">
                            {{Support::show($itemActiveTestSpinToday,'province_name')}}
                        </a>
                    @endforeach
                </div>
            </form>
        </div>
        @include('test_spins.result_box')
        <div class="clearfix"></div>
        @php
            $listSeeMoreLink = Support::extractJson($currentItem->see_more_link);
        @endphp
        @if (count($listSeeMoreLink) > 0)
            <div class="see-more">
                <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm:</div>
                <ul class="list-html-link two-column">
                    @foreach ($listSeeMoreLink as $itemSeeMoreLink)
                        <li>{{Support::show($itemSeeMoreLink,'name')}} 
                            <a href="{{Support::show($itemSeeMoreLink,'link')}}">{{Support::show($itemSeeMoreLink,'title')}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
@include('test_spins.lucky_box')
<div class="box box-html">
    {!!Support::show($currentItem,'content')!!}
</div>
<div class="box box-news">
    <h3 class="tit-mien"><strong>Thảo luận kết quả xổ số</strong></h3>
    <ul>
        <li>
            <span class="ic"></span><a href="dien-dan-xo-so">Box thảo luận</a>
        </li>
    </ul>
</div>
<div class="box">
    <h3 class="tit-mien"><strong>Thảo luận</strong></h3>
    <div id="comment" class="fb-comments" data-href="{{url()->to($currentItem->slug)}}" data-width="100%" data-numposts="5"></div>
</div>
@endsection
@section('jsl')
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/jquery.3.4.1.min.js') }}"></script>
@endsection
@section('js')
    <script>
        document.querySelectorAll(".trial-button").forEach(item => item.addEventListener('click', () =>
        {
            xsmn.startTrialRolling("#trial-box",JSON.parse('{"provinceCode":"MB","provinceName":"Mi\u1ec1n B\u1eafc","resultDate":"1659459600000","tuong_thuat":false,"lotData":{"DB":["22646"],"MaDb":["7EK","2FL","6SF","2CF","5SM","1ZC"],"1":["04801"],"2":["97569","91607"],"3":["89001","24630","57108","93691","15252","06249"],"4":["6662","7285","6595","7712"],"5":["6255","3381","0719","5429","4063","7913"],"6":["707","224","736"],"7":["83","78","64","88"]}}'), item.getAttribute('data-interval'));
            document.getElementById('lottery-sound').play();
            }               
        ));
    </script>
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/test_spin.js') }}"></script>
    <audio id="lottery-sound"><source src="theme/frontend/audio/xo-so-mien-bac.mp3" type="audio/mpeg"></audio>
@endsection