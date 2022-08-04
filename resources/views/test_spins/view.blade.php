@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('test_spin_categories', $currentItem)}}
@endsection
@section('main')
<div class="box quay-thu">
    <ul class="tab-panel tab-auto">
        @foreach ($listItemTestSpinCategory as $item)
            <li class="{{$item->id == $currentItem->category->id ? 'active':''}}">
                <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'short_name')}}">{{Support::show($item,'short_name')}}</a>
            </li>
        @endforeach
    </ul>
    <div class="tit-mien clearfix">
        <h2>
            Kết quả quay thử {{Support::show($currentItem,'province_name')}} ngày {{now()->format('d-m-Y')}}
        </h2>
    </div>
    <div class="box" id="trial-box">
        <div class="txt-center bg-orange">
            <form id="trial_form" class="form-horizontal" action="{{Support::show($currentItem,'slug')}}" method="post">
                @csrf
                <div class="form-group">
                    <select id="province_name" name="province_name" onchange="document.getElementById('trial_form').submit();">
                        <option value="">Chọn đài quay thử</option>
                        @if ($currentItem->category->id == 1)
                            <option value="mien-bac">Miền Bắc</option>
                        @endif
                        @foreach ($listItems as $item)
                            <option value="{{Support::show($item,'province_code')}}" {{$currentItem->id == $item->id ? 'selected':''}}>{{Support::show($item,'province_name')}}</option>
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
        @if ($currentItem->category->id == 1)
            @include('test_spins.result_box_single_mb')
        @else
            @include('test_spins.result_box_single_mn')
        @endif
        <div class="clearfix"></div>
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
    <script type="text/javascript" src="{{ Support::asset('theme/frontend/js/test_spin.js') }}"></script>
    <script>
        xsmn.refreshCtrlPanel(document.querySelector("#trial-box" + " [data-id='kq'] table"));
        document.querySelectorAll(".trial-button").forEach(item => item.addEventListener('click', () =>
        {
            xsmn.startTrialRolling("#trial-box",JSON.parse('{!!$dataTestSpin!!}'), item.getAttribute('data-interval'));
            document.getElementById('lottery-sound').play();
            }               
        ));
    </script>
    <audio id="lottery-sound"><source src="theme/frontend/audio/xo-so-mien-bac.mp3" type="audio/mpeg"></audio>
@endsection