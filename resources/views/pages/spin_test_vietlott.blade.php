@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('page', $currentItem)}}
@endsection
@section('main')
<style>
    #quaythu_mega_btn, #quaythu_max4d_btn, #quaythu_power_btn{width: 50%;font-size: 15px;font-weight: bold}
    #load_kq_mega_0{border-top: none}
</style>
<div class="mega645">
    <div class="box">
        <ul class="tab-panel tab-auto">
            @foreach ($listItemTestSpinCategory as $item)
                <li>
                    <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'short_name')}}">{{Support::show($item,'short_name')}}</a>
                </li>
            @endforeach
        </ul>
        <h2 class="tit-mien bold">
            <a href="/kqxs-mega-645-chu-nhat-ket-qua-xo-so-mega-645-vietlott-chu-nhat-truc-tiep.html" title="XS Mega chủ nhật"><span class="f16 clnote underline">XS Mega chủ nhật</span></a>
            - Kết quả xổ số Mega ngày 07/08/2022 
        </h2>
        <div class="box-html">
            Lưu ý: Những thông tin về cách quay số lấy hên xổ số Vietlott Mega 6/45 hoàn toàn mang tính chất tham khảo. Chúc các bạn may mắn.
        </div>
        <div class="txt-center pad10">
            <button class="btn btn-danger" id="quaythu_mega_btn" type="submit">Quay thử</button>
        </div>
        <ul class="results">
            <li id="load_kq_mega_0">
                <div class="clearfix">
                    <table class="data">
                        <tbody>
                            <tr>
                                <td><i class="imgloadig"></i></td>
                                <td><i class="imgloadig"></i></td>
                                <td><i class="imgloadig"></i></td>
                                <td><i class="imgloadig"></i></td>
                                <td><i class="imgloadig"></i></td>
                                <td><i class="imgloadig"></i></td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <p class="txt-center">Giá trị Jackpot: <strong>28.638.819.500 đồng</strong></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table class="data2">
                    <tbody>
                        <tr>
                            <td>Giải thưởng</td>
                            <td>Trùng khớp</td>
                            <td>Số lượng giải</td>
                            <td>Giá trị giải (đồng)</td>
                        </tr>
                        <tr>
                            <td class="clnote">Jackpot</td>
                            <td><i></i> <i></i> <i></i> <i></i> <i></i> <i></i></td>
                            <td>0</td>
                            <td class="clnote">28.638.819.500</td>
                        </tr>
                        <tr>
                            <td class="clnote">Giải nhất</td>
                            <td><i></i> <i></i> <i></i> <i></i> <i></i></td>
                            <td>0</td>
                            <td>10.000.000</td>
                        </tr>
                        <tr>
                            <td class="clnote">Giải nhì</td>
                            <td><i></i> <i></i> <i></i> <i></i></td>
                            <td>0</td>
                            <td>300.000</td>
                        </tr>
                        <tr>
                            <td class="clnote">Giải ba</td>
                            <td><i></i> <i></i> <i></i></td>
                            <td>0</td>
                            <td>30.000</td>
                        </tr>
                    </tbody>
                </table>
            </li>
        </ul>
    </div>
</div>
<div class="mega645 power655">
    <div class="box">
        <h2 class="tit-mien bold">
            <a href="/kqxs-power-mega-655-thu-7-ket-qua-xo-so-mega-power-655-vietlott-thu-7-hang-tuan.html" title="XS Power thứ 7"><span class="f16 clnote underline">XS Power thứ 7</span></a>
            - Kết quả xổ số Power ngày 06/08/2022 
        </h2>
        <div class="box-html">
            Lưu ý: Những thông tin về cách quay số lấy hên xổ số Vietlott Power 6/55 hoàn toàn mang tính chất tham khảo. Chúc các bạn may mắn.
        </div>
        <div class="txt-center pad10">
            <button class="btn  btn-danger" id="quaythu_power_btn" type="submit">Quay thử</button>
        </div>
        <ul class="results">
            <li id="load_kq_power_0">
                <div class="clearfix">
                    <table class="data">
                        <tbody>
                            <tr>
                                <td><i class="imgloadig"></i></td>
                                <td><i class="imgloadig"></i></td>
                                <td><i class="imgloadig"></i></td>
                                <td><i class="imgloadig"></i></td>
                                <td><i class="imgloadig"></i></td>
                                <td><i class="imgloadig"></i></td>
                                <td><i class="imgloadig"></i></td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <p class="txt-center">Giá trị Jackpot 1: <strong>36.032.949.300 đồng</strong></p>
                                    <p class="txt-center">Giá trị Jackpot 2: <strong>5.023.508.900 đồng</strong></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table class="data2">
                    <tbody>
                        <tr>
                            <td>Giải thưởng</td>
                            <td>Trùng khớp</td>
                            <td>Số lượng giải</td>
                            <td>Giá trị giải (đồng)</td>
                        </tr>
                        <tr>
                            <td class="clnote">Jackpot 1</td>
                            <td><i></i> <i></i> <i></i> <i></i> <i></i> <i></i></td>
                            <td>0</td>
                            <td class="clnote">36.032.949.300</td>
                        </tr>
                        <tr>
                            <td class="clnote">Jackpot 2</td>
                            <td><i></i> <i></i> <i></i> <i></i> <i></i> | <i class="clnote"></i></td>
                            <td>0</td>
                            <td class="clnote">5.023.508.900</td>
                        </tr>
                        <tr>
                            <td class="clnote">Giải nhất</td>
                            <td><i></i> <i></i> <i></i> <i></i> <i></i></td>
                            <td>0</td>
                            <td>40.000.000</td>
                        </tr>
                        <tr>
                            <td class="clnote">Giải nhì</td>
                            <td><i></i> <i></i> <i></i> <i></i></td>
                            <td>0</td>
                            <td>500.000</td>
                        </tr>
                        <tr>
                            <td class="clnote">Giải ba</td>
                            <td><i></i> <i></i> <i></i></td>
                            <td>0</td>
                            <td>50.000</td>
                        </tr>
                    </tbody>
                </table>
            </li>
        </ul>
    </div>
</div>
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
    let kqArrMega = ['01', '20', '22', '23', '35', '41'];
    let kqArrPower = ['07', '16', '17', '21', '24', '40', '52'];
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