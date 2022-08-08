@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('page', $currentItem)}}
@endsection
@section('main')
<style>
    #quaythu_mega_btn, #quaythu_max4d_btn, #quaythu_power_btn{width: 50%;font-size: 15px;font-weight: bold}
    #load_kq_mega_0{border-top: none}
</style>
{!!Support::show($currentItem,'moreinfo')!!}
<div class="box box-html">
    {!!Support::show($currentItem,'content')!!}
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
    let kqArrMega = [{!!App\Models\TestSpinViettlotData::getDataTestSpin('mega',now())!!}];
    let kqArrPower = [{!!App\Models\TestSpinViettlotData::getDataTestSpin('power',now())!!}];
    document.getElementById("quaythu_mega_btn").onclick = function () {
        let i = 0;
        mega = setInterval(function () {
            $("#load_kq_mega_0").find('.data i.imgloadig:eq(0)').replaceWith('<i>' + kqArrMega[i++] + '</i>');
            if (i == 6) {
                clearInterval(mega);
            }
        }, 2000);
    }

    document.getElementById("quaythu_power_btn").onclick = function () {
        let j = 0;
        power = setInterval(function () {
            $("#load_kq_power_0").find('.data i.imgloadig:eq(0)').replaceWith('<i>' + kqArrPower[j++] + '</i>');
            if (j == 7) {
                clearInterval(power);
            }
        }, 2000);
    }
</script>
@endsection