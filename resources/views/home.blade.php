@extends('index')
@section('main')
    @include('partials.link_du_doan')
    <div class="box">
        <div class="bg_gray">
            <div class=" opt_date_full clearfix">
                <a class="ic-pre fl" href="https://xoso.me/kqxs-19-7-2022-ket-qua-xo-so-ngay-19-7-2022.html"
                    title="Kết quả xổ số ngày 19/07/2022">
                </a>
                <label>
                    <strong> Thứ tư </strong> - <input class="nobor hasDatepicker" id="searchDate" type="text"
                        value="20/07/2022" />
                    <span class="ic ic-calendar">
                    </span>
                </label>
                <a class="ic-next" href="https://xoso.me/kqxs-21-7-2022-ket-qua-xo-so-ngay-21-7-2022.html"
                    title="Kết quả xổ số ngày 21/07/2022">
                </a>
            </div>
        </div>
    </div>
    <div class="box-kq">
        <div class="box mo-thuong-ngay">
            <div class="tit-mien s16">
                <strong> Các tỉnh mở thưởng hôm nay </strong>
            </div>
            <table class="table-fixed">
                <tr>
                    <td>
                        <table>
                            <?php $mns = \Lotto\Models\LottoCategory::find(3)->lottoTodayItems();
                            $count = count($mns); ?>
                            @foreach ($mns as $item)
                                <tr>
                                    <td>
                                        <a href="{{ $item->slug }}" title="Xổ Số {{ $item->name }}"> {{ $item->name }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                    <td>
                        <table>
                            <?php $mts = \Lotto\Models\LottoCategory::find(4)->lottoTodayItems(); ?>
                            @foreach ($mts as $item)
                                <tr>
                                    <td>
                                        <a href="{{ $item->slug }}" title="Xổ Số {{ $item->name }}"> {{ $item->name }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @for ($i = 0; $i < $count - count($mts); $i++)
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            @endfor
                        </table>
                    </td>
                    <td>
                        <table>
                            <tr>
                                <?php $mb = \Lotto\Models\LottoCategory::find(1); ?>
                                <td>
                                    <a href="{{ $mb->slug }}" title="{{ $mb->name }}"> Miền Bắc </a>
                                </td>
                            </tr>
                            <?php $dts = \Lotto\Models\LottoCategory::find(2)->lottoTodayItems(); ?>
                            @foreach ($dts as $item)
                                <tr>
                                    <td>
                                        <a href="{{ $item->slug }}" title="Xổ Số {{ $item->name }}">
                                            {{ $item->name }} </a>
                                    </td>
                                </tr>
                            @endforeach
                            @for ($i = 0; $i < $count - count($dts) - 1; $i++)
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            @endfor
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        @include('home/mien_bac', [
            'lottoCategory' => $lottoCategoryMb,
            'lottoItem' => $lottoItemMb,
            'lottoRecord' => $lottoRecordMb,
        ])
        @include('home/mien_nam', [
            'lottoCategory' => $lottoCategoryMn,
            'lottoItem' => $lottoItemMn,
            'lottoRecord' => $lottoRecordMn,
            'lottoItemMnCollection' => $lottoItemMnCollectionMn,
        ])
        @include('home/mien_trung', [
            'lottoCategory' => $lottoCategoryMt,
            'lottoItem' => $lottoItemMt,
            'lottoRecord' => $lottoRecordMt,
            'lottoItemMnCollection' => $lottoItemMnCollectionMt,
        ])
        <div class="box mega645">
            <h2 class="tit-mien clearfix">
                <strong>
                    <a class="title-a"
                        href="https://xoso.me/kqxs-mega-645-ket-qua-xo-so-mega-6-45-vietlott-ngay-hom-nay.html"
                        title="Xổ số Mega"> Xổ số Mega </a> chủ nhật ngày 17-7-2022 </strong>
            </h2>
            <ul class="results">
                <li id="load_kq_mega_0">
                    <div class="clearfix">
                        <table class="data">
                            <tbody>
                                <tr>
                                    <td>
                                        <i> 07 </i>
                                    </td>
                                    <td>
                                        <i> 13 </i>
                                    </td>
                                    <td>
                                        <i> 20 </i>
                                    </td>
                                    <td>
                                        <i> 23 </i>
                                    </td>
                                    <td>
                                        <i> 27 </i>
                                    </td>
                                    <td>
                                        <i> 29 </i>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <p class="txt-center"> Giá trị Jackpot: <strong> 15.129.926.500 đồng
                                            </strong>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <table class="data2">
                        <tbody>
                            <tr>
                                <td> Giải thưởng </td>
                                <td> Trùng khớp </td>
                                <td> Số lượng giải </td>
                                <td> Giá trị giải (đồng) </td>
                            </tr>
                            <tr>
                                <td class="clnote"> Jackpot </td>
                                <td>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                </td>
                                <td> 0 </td>
                                <td class="clnote"> 15.129.926.500 </td>
                            </tr>
                            <tr>
                                <td class="clnote"> Giải nhất </td>
                                <td>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                </td>
                                <td> 12 </td>
                                <td> 10.000.000 </td>
                            </tr>
                            <tr>
                                <td class="clnote"> Giải nhì </td>
                                <td>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                </td>
                                <td> 876 </td>
                                <td> 300.000 </td>
                            </tr>
                            <tr>
                                <td class="clnote"> Giải ba </td>
                                <td>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                </td>
                                <td> 15.176 </td>
                                <td> 30.000 </td>
                            </tr>
                        </tbody>
                    </table>
                </li>
            </ul>
        </div>
        <div class="power655 box mega645">
            <h2 class="tit-mien clearfix">
                <strong>
                    <a class="title-a"
                        href="https://xoso.me/kqxs-power-6-55-ket-qua-xo-so-power-6-55-vietlott-ngay-hom-nay.html"
                        title="Xổ số Power"> Xổ số Power </a> thứ 3 ngày 19-7-2022 </strong>
            </h2>
            <ul class="results">
                <li id="load_kq_power_0">
                    <div class="clearfix">
                        <table class="data">
                            <tbody>
                                <tr>
                                    <td>
                                        <i> 08 </i>
                                    </td>
                                    <td>
                                        <i> 09 </i>
                                    </td>
                                    <td>
                                        <i> 33 </i>
                                    </td>
                                    <td>
                                        <i> 34 </i>
                                    </td>
                                    <td>
                                        <i> 35 </i>
                                    </td>
                                    <td>
                                        <i> 52 </i>
                                    </td>
                                    <td>
                                        <i> 36 </i>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7">
                                        <p class="txt-center"> Giá trị Jackpot 1: <strong> 33.952.631.250 đồng
                                            </strong>
                                        </p>
                                        <p class="txt-center"> Giá trị Jackpot 2: <strong> 3.439.181.250 đồng
                                            </strong>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <table class="data2">
                        <tbody>
                            <tr>
                                <td> Giải thưởng </td>
                                <td> Trùng khớp </td>
                                <td> Số lượng giải </td>
                                <td> Giá trị giải (đồng) </td>
                            </tr>
                            <tr>
                                <td class="clnote"> Jackpot 1 </td>
                                <td>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                </td>
                                <td> 0 </td>
                                <td class="clnote"> 33.952.631.250 </td>
                            </tr>
                            <tr>
                                <td class="clnote"> Jackpot 2 </td>
                                <td>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i> | <i class="clnote">
                                    </i>
                                </td>
                                <td> 0 </td>
                                <td class="clnote"> 3.439.181.250 </td>
                            </tr>
                            <tr>
                                <td class="clnote"> Giải nhất </td>
                                <td>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                </td>
                                <td> 13 </td>
                                <td> 40.000.000 </td>
                            </tr>
                            <tr>
                                <td class="clnote"> Giải nhì </td>
                                <td>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                </td>
                                <td> 570 </td>
                                <td> 500.000 </td>
                            </tr>
                            <tr>
                                <td class="clnote"> Giải ba </td>
                                <td>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                    <i>
                                    </i>
                                </td>
                                <td> 12.884 </td>
                                <td> 50.000 </td>
                            </tr>
                        </tbody>
                    </table>
                </li>
            </ul>
        </div>
        <div class="box">
            <h2 class="tit-mien clearfix">
                <strong>
                    <a class="title-a" href="https://xoso.me/xo-so-max3d-pro.html" title="Xổ số Max 3D Pro"> Xổ
                        số Max 3D Pro </a> thứ 3 ngày 19-7-2022 </strong>
            </h2>
            <div id="load_kq_3dpro_0">
                <div class="one-city" data-id="kq">
                    <table class="kqmb kqmax3d">
                        <thead>
                            <tr>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <b> Giải </b>
                                </td>
                                <td colspan="12">
                                    <strong> Dãy số trúng </strong>
                                </td>
                                <td>
                                    <b> Giải thưởng </b>
                                </td>
                            </tr>
                            <tr class="db">
                                <td> ĐB </td>
                                <td class="number" colspan="6">
                                    <strong> 178 </strong>
                                </td>
                                <td class="number" colspan="6">
                                    <strong> 130 </strong>
                                </td>
                                <td> 2 tỷ </td>
                            </tr>
                            <tr class="db">
                                <td> Phụ ĐB </td>
                                <td class="number" colspan="6">
                                    <strong> 130 </strong>
                                </td>
                                <td class="number" colspan="6">
                                    <strong> 178 </strong>
                                </td>
                                <td> 400tr </td>
                            </tr>
                            <tr>
                                <td rowspan="2"> Nhất </td>
                                <td colspan="12"> Trùng 2 bộ ba số bất kỳ trong 4 bộ ba số </td>
                                <td rowspan="2"> 30tr </td>
                            </tr>
                            <tr class="border-right">
                                <td class="number" colspan="3">
                                    <strong> 114 </strong>
                                </td>
                                <td class="number" colspan="3">
                                    <strong> 591 </strong>
                                </td>
                                <td class="number" colspan="3">
                                    <strong> 898 </strong>
                                </td>
                                <td class="number" colspan="3">
                                    <strong> 732 </strong>
                                </td>
                            </tr>
                            <tr class="border-right">
                                <td rowspan="3"> Nhì </td>
                                <td colspan="12"> Trùng 2 bộ ba số bất kỳ trong 4 bộ ba số: </td>
                                <td rowspan="3"> 10tr </td>
                            </tr>
                            <tr class="giai3 border-right">
                                <td class="number" colspan="4">
                                    <strong> 114 </strong>
                                </td>
                                <td class="number" colspan="4">
                                    <strong class=""> 019 </strong>
                                </td>
                                <td class="number" colspan="4">
                                    <strong class=""> 585 </strong>
                                </td>
                            </tr>
                            <tr class="bg_white border-right">
                                <td class="number" colspan="4">
                                    <strong> 041 </strong>
                                </td>
                                <td class="number" colspan="4">
                                    <strong class=""> 594 </strong>
                                </td>
                                <td class="number" colspan="4">
                                    <strong class=""> 531 </strong>
                                </td>
                            </tr>
                            <tr class="border-right">
                                <td rowspan="3"> Ba </td>
                                <td colspan="12"> Trùng 2 bộ ba số bất kỳ trong 8 bộ ba số: </td>
                                <td rowspan="3"> 4tr </td>
                            </tr>
                            <tr class="border-right">
                                <td class="number" colspan="3">
                                    <strong> 181 </strong>
                                </td>
                                <td class="number" colspan="3">
                                    <strong> 747 </strong>
                                </td>
                                <td class="number" colspan="3">
                                    <strong> 905 </strong>
                                </td>
                                <td class="number" colspan="3">
                                    <strong> 971 </strong>
                                </td>
                            </tr>
                            <tr class="border-right">
                                <td class="number" colspan="3">
                                    <strong> 329 </strong>
                                </td>
                                <td class="number" colspan="3">
                                    <strong> 669 </strong>
                                </td>
                                <td class="number" colspan="3">
                                    <strong> 262 </strong>
                                </td>
                                <td class="number" colspan="3">
                                    <strong> 367 </strong>
                                </td>
                            </tr>
                            <tr>
                                <td> Tư </td>
                                <td colspan="12"> Trùng bất kỳ 2 bộ ba số quay thưởng của giải Đặc biệt, Nhất,
                                    Nhì hoặc Ba </td>
                                <td> 1tr </td>
                            </tr>
                            <tr>
                                <td> Năm </td>
                                <td colspan="12"> Trùng 1 bộ ba số quay thưởng giải Đặc biệt bất kỳ </td>
                                <td> 100k </td>
                            </tr>
                            <tr class="border-right border-bottom">
                                <td> Sáu </td>
                                <td colspan="12"> Trùng 1 bộ ba số quay thưởng giải Nhất, Nhì hoặc Ba bất kỳ
                                </td>
                                <td> 40k </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="box">
            <h2 class="tit-mien clearfix">
                <strong>
                    <a class="title-a" href="https://xoso.me/kqxs-max3d-ket-qua-xo-so-max-3d-vietlott.html"
                        title="Xổ số Max 3D"> Xổ số Max 3D </a> thứ 2 ngày 18-7-2022 </strong>
            </h2>
            <div id="load_kq_3d_0">
                <div class="one-city" data-id="kq">
                    <table class="kqmb kqmax3d">
                        <thead>
                            <tr>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <b> Giải </b>
                                </td>
                                <td colspan="12">
                                    <strong> Dãy số trúng </strong>
                                </td>
                                <td>
                                    <b> SL </b>
                                </td>
                                <td>
                                    <b> Giá trị </b>
                                </td>
                            </tr>
                            <tr class="db">
                                <td> ĐB </td>
                                <td class="number" colspan="6">
                                    <strong> 525 </strong>
                                </td>
                                <td class="number" colspan="6">
                                    <strong> 694 </strong>
                                </td>
                                <td> 76 </td>
                                <td> 1tr </td>
                            </tr>
                            <tr>
                                <td> Nhất </td>
                                <td class="number" colspan="3">
                                    <strong> 427 </strong>
                                </td>
                                <td class="number" colspan="3">
                                    <strong> 600 </strong>
                                </td>
                                <td class="number" colspan="3">
                                    <strong> 594 </strong>
                                </td>
                                <td class="number" colspan="3">
                                    <strong> 823 </strong>
                                </td>
                                <td> 187 </td>
                                <td> 350N </td>
                            </tr>
                            <tr class="giai3">
                                <td rowspan="2"> Nhì </td>
                                <td class="number" colspan="4">
                                    <strong> 844 </strong>
                                </td>
                                <td class="number" colspan="4">
                                    <strong class=""> 287 </strong>
                                </td>
                                <td class="number" colspan="4">
                                    <strong class=""> 042 </strong>
                                </td>
                                <td rowspan="2"> 149 </td>
                                <td rowspan="2"> 210N </td>
                            </tr>
                            <tr class="bg_white border-right">
                                <td class="number" colspan="4">
                                    <strong> 574 </strong>
                                </td>
                                <td class="number" colspan="4">
                                    <strong class=""> 456 </strong>
                                </td>
                                <td class="number" colspan="4">
                                    <strong class=""> 002 </strong>
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="2"> Ba </td>
                                <td class="number" colspan="3">
                                    <strong> 954 </strong>
                                </td>
                                <td class="number" colspan="3">
                                    <strong> 522 </strong>
                                </td>
                                <td class="number" colspan="3">
                                    <strong> 952 </strong>
                                </td>
                                <td class="number" colspan="3">
                                    <strong> 797 </strong>
                                </td>
                                <td rowspan="2"> 0 </td>
                                <td rowspan="2"> 100N </td>
                            </tr>
                            <tr class="border-right border-bottom">
                                <td class="number" colspan="3">
                                    <strong> 456 </strong>
                                </td>
                                <td class="number" colspan="3">
                                    <strong> 059 </strong>
                                </td>
                                <td class="number" colspan="3">
                                    <strong> 462 </strong>
                                </td>
                                <td class="number" colspan="3">
                                    <strong> 595 </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="see-more">
                    <div class="bold see-more-title"> Max 3D+ </div>
                </div>
                <div class="col-firstlast colgiai" data-id="dd">
                    <table class="firstlast-mn kqmax3d">
                        <tbody>
                            <tr class="header bold">
                                <th class="first"> Giải </th>
                                <th> Kết quả </th>
                                <th> SL giải </th>
                                <th> Giá trị (đ) </th>
                            </tr>
                            <tr>
                                <td>
                                    <b class=""> G1 </b>
                                </td>
                                <td> Trùng 2 số G1 </td>
                                <td> 0 </td>
                                <td> 1.000.000.000 </td>
                            </tr>
                            <tr>
                                <td>
                                    <b class=""> G2 </b>
                                </td>
                                <td> Trùng 2 số G2 </td>
                                <td> 0 </td>
                                <td> 40.000.000 </td>
                            </tr>
                            <tr>
                                <td>
                                    <b class=""> G3 </b>
                                </td>
                                <td> Trùng 2 số G3 </td>
                                <td> 0 </td>
                                <td> 10.000.000 </td>
                            </tr>
                            <tr>
                                <td>
                                    <b class=""> G4 </b>
                                </td>
                                <td> Trùng 2 số G.KK </td>
                                <td> 0 </td>
                                <td> 5.000.000 </td>
                            </tr>
                            <tr>
                                <td>
                                    <b class=""> G5 </b>
                                </td>
                                <td> Trùng 2 số G1, G2, G3, G.KK </td>
                                <td> 0 </td>
                                <td> 1.000.000 </td>
                            </tr>
                            <tr>
                                <td>
                                    <b class=""> G6 </b>
                                </td>
                                <td> Trùng 1 số G1 </td>
                                <td> 0 </td>
                                <td> 150.000 </td>
                            </tr>
                            <tr>
                                <td>
                                    <b class=""> G7 </b>
                                </td>
                                <td> Trùng 1 số G1, G2, G3, G.KK </td>
                                <td> 0 </td>
                                <td> 40.000 </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="box box-html">
            <p>
                <span style="font-size:14px"> XS - <strong>
                        <a href="https://xoso.me/" title="KQXS">
                            <span style="color:rgb(0, 0, 255)"> KQXS </span>
                        </a>
                    </strong> . Tường thuật Kết Quả Xổ Số Kiến Thiết 3 miền hôm nay trực tiếp nhanh, chính xác
                    nhất. Xem/dem xổ số trực tiếp 3 miền hàng ngày miễn phí từ trường quay từ các tỉnh trên toàn
                    quốc từ 16h15p đến 18h30p </span>
            </p>
            <p dir="ltr">
                <span style="font-size:14px"> Tại trang web, bạn có thể dò/coi kết quả vé xổ số kiến thiết trực
                    tuyến tất cả ngày hôm nay đài, tỉnh gì quay tại các link dưới đây: </span>
            </p>
            <p>
                <span style="font-size:14px"> + <strong>
                        <a href="https://xoso.me/xsmb-sxmb-xstd-xshn-kqxsmb-ket-qua-xo-so-mien-bac.html"
                            title="Kết quả xổ số miền Bắc">
                            <span style="color:#0000FF"> Kết quả xổ số miền Bắc </span>
                        </a>
                    </strong>
                </span>
            </p>
            <p>
                <span style="font-size:14px"> + <strong>
                        <a href="https://xoso.me/xsmn-sxmn-kqxsmn-ket-qua-xo-so-mien-nam.html"
                            title="Kết quả xổ số miền Nam">
                            <span style="color:#0000FF"> Kết quả xổ số miền Nam </span>
                        </a>
                    </strong>
                </span>
            </p>
            <p>
                <span style="font-size:14px"> + <strong>
                        <a href="https://xoso.me/xsmt-sxmt-kqxsmt-ket-qua-xo-so-mien-trung.html"
                            title="Kết quả xổ số miền Trung">
                            <span style="color:#0000FF"> Kết quả xổ số miền Trung </span>
                        </a>
                    </strong>
                </span>
            </p>
            <p>
                <span style="font-size:14px"> + <strong>
                        <a href="https://xoso.me/ket-qua-xo-so-dien-toan.html" title="Kết quả xổ số điện toán">
                            <span style="color:#0000FF"> Kết quả xổ số điện toán </span>
                        </a>
                    </strong> : 123, 6x36, xổ số thần tài </span>
            </p>
            <p>
                <span style="font-size:14px"> + <strong>
                        <a href="https://xoso.me/kqxs-mega-645-ket-qua-xo-so-mega-6-45-vietlott-ngay-hom-nay.html"
                            title="Kết quả xổ số Mega 645">
                            <span style="color:#0000FF"> Kết quả xổ số Mega 645 </span>
                        </a>
                    </strong>
                </span>
            </p>
            <p>
                <span style="font-size:14px"> + <strong>
                        <a href="https://xoso.me/kqxs-max4d-ket-qua-xo-so-dien-toan-tu-chon-so-max-4d-vietlott-ngay-hom-nay.html"
                            title="Kết quả xổ số Max 4d">
                            <span style="color:#0000FF"> Kết quả xổ số Max 4d </span>
                        </a>
                    </strong>
                </span>
            </p>
            <p>
                <span style="font-size:14px"> + <strong>
                        <a href="https://xoso.me/kqxs-power-6-55-ket-qua-xo-so-power-6-55-vietlott-ngay-hom-nay.html"
                            title="Kết quả xổ số Power 655">
                            <span style="color:#0000FF"> Kết quả xổ số Power 655 </span>
                        </a>
                    </strong>
                </span>
            </p>
            <p>
                <span style="font-size:14px"> + <strong>
                        <a href="https://xoso.me/kqxs-max3d-ket-qua-xo-so-max-3d-vietlott.html"
                            title="Kết quả xổ số Max 3D">
                            <span style="color:#0000FF"> Kết quả xổ số Max 3D </span>
                        </a>
                    </strong>
                </span>
            </p>
            <p>
                <span style="font-size:14px"> + <strong>
                        <a href="https://xoso.me/xs-keno-vietlott-xo-so-tu-chon-keno-vietlott-hom-nay.html"
                            title="Kết quả xổ số Keno">
                            <span style="color:#0000FF"> Kết quả xổ số Keno </span>
                        </a>
                    </strong>
                </span>
            </p>
            <p>
                <span style="font-size:14px"> + <strong>
                        <a href="https://xoso.me/du-doan-ket-qua-xo-so-kqxs-c229.html" title="Dự đoán kết quả xổ số">
                            <span style="color:#0000FF"> Dự đoán kết quả xổ số </span>
                        </a>
                    </strong>
                </span>
            </p>
            <p dir="ltr">
                <span style="font-size:14px"> Luôn truy cập vào website của chúng tôi để cập nhật những tin tức
                    xổ số bữa ngay chuẩn và nhanh nhất. Chúc bạn may mắn! </span>
            </p>
        </div>
    </div>
@endsection
