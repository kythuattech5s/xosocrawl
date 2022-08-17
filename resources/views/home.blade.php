@extends('index')
@section('main')
@include('partials.link_du_doan')
<div class="box">
    <div class="bg_gray">
        <div class=" opt_date_full clearfix">
            <a class="ic-pre fl" href="https://xoso.me/kqxs-19-7-2022-ket-qua-xo-so-ngay-19-7-2022.html" title="Kết quả xổ số ngày 19/07/2022">
            </a>
            <label>
                <strong> Thứ tư </strong> - <input class="nobor hasDatepicker" id="searchDate" type="text" value="20/07/2022"/>
                <span class="ic ic-calendar">
                </span>
            </label>
            <a class="ic-next" href="https://xoso.me/kqxs-21-7-2022-ket-qua-xo-so-ngay-21-7-2022.html" title="Kết quả xổ số ngày 21/07/2022">
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
                            <?php $mns = \Lotto\Models\LottoCategory::find(3)->lottoTodayItems(); ?>
                            @foreach($mns as $item)
                            <tr>
                                <td>
                                    <a href="{{$item->slug}}" title="Xổ Số {{$item->name}}"> {{$item->name}} </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </td>
                    <td>
                        <table>
                            <?php $mts = \Lotto\Models\LottoCategory::find(4)->lottoTodayItems(); ?>
                            @foreach($mts as $item)
                            <tr>
                                <td>
                                    <a href="{{$item->slug}}" title="Xổ Số {{$item->name}}"> {{$item->name}} </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </td>
                    <td>
                        <table>
                            <tr>
                                <?php $mb = \Lotto\Models\LottoCategory::find(1); ?>
                                <td>
                                    <a href="{{$mb->slug}}" title="{{$mb->name}}"> Miền Bắc </a>
                                </td>
                            </tr>
                            <?php $dts = \Lotto\Models\LottoCategory::find(2)->lottoTodayItems(); ?>
                            @foreach($dts as $item)
                            <tr>
                                <td>
                                    <a href="{{$item->slug}}" title="Xổ Số {{$item->name}}"> {{$item->name}} </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
        </table>
    </div>
    <div class="box">
        <h2 class="tit-mien clearfix">
            <strong>
                <a class="title-a" href="https://xoso.me/xsmb-sxmb-xstd-xshn-kqxsmb-ket-qua-xo-so-mien-bac.html" title="XSMB"> XSMB </a> » <a class="title-a" href="https://xoso.me/xsmb-thu-3-ket-qua-xo-so-mien-bac-thu-3.html" title="XSMB thứ 3">
                    XSMB thứ 3 </a> » <a class="title-a" href="https://xoso.me/xsmb-19-7-2022-ket-qua-xo-so-mien-bac-ngay-19-7-2022.html" title="XSMB 19-7-2022"> XSMB 19-7-2022 </a>
            </strong>
        </h2>
        <div id="load_kq_mb_0">
            <div class="one-city" data-id="kq" data-region="1">
                <table class="kqmb extendable">
                    <tbody>
                        <tr>
                            <td class="v-giai madb" colspan="13">
                                <span class="v-madb"> 14AL - 8AL - 13AL - 9AL - 15AL - 11AL </span>
                            </td>
                        </tr>
                        <tr class="db">
                            <td class="txt-giai"> ĐB </td>
                            <td class="v-giai number ">
                                <span class="v-gdb " data-nc="5"> 53393 </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="txt-giai"> Giải 1 </td>
                            <td class="v-giai number">
                                <span class="v-g1" data-nc="5"> 88480 </span>
                            </td>
                        </tr>
                        <tr class="bg_ef">
                            <td class="txt-giai"> Giải 2 </td>
                            <td class="v-giai number">
                                <span class="v-g2-0 " data-nc="5"> 98910 </span>
                                <span class="v-g2-1 " data-nc="5"> 16736 </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="txt-giai"> Giải 3 </td>
                            <td class="v-giai number">
                                <span class="v-g3-0 " data-nc="5"> 45267 </span>
                                <span class="v-g3-1 " data-nc="5"> 23019 </span>
                                <span class="v-g3-2 " data-nc="5"> 53467 </span>
                                <span class="v-g3-3 " data-nc="5"> 28429 </span>
                                <span class="v-g3-4 " data-nc="5"> 38832 </span>
                                <span class="v-g3-5 " data-nc="5"> 40046 </span>
                            </td>
                        </tr>
                        <tr class="bg_ef">
                            <td class="txt-giai"> Giải 4 </td>
                            <td class="v-giai number">
                                <span class="v-g4-0 " data-nc="4"> 6803 </span>
                                <span class="v-g4-1 " data-nc="4"> 6055 </span>
                                <span class="v-g4-2 " data-nc="4"> 3124 </span>
                                <span class="v-g4-3 " data-nc="4"> 0841 </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="txt-giai"> Giải 5 </td>
                            <td class="v-giai number">
                                <span class="v-g5-0 " data-nc="4"> 4290 </span>
                                <span class="v-g5-1 " data-nc="4"> 7564 </span>
                                <span class="v-g5-2 " data-nc="4"> 9959 </span>
                                <span class="v-g5-3 " data-nc="4"> 6429 </span>
                                <span class="v-g5-4 " data-nc="4"> 4218 </span>
                                <span class="v-g5-5 " data-nc="4"> 2126 </span>
                            </td>
                        </tr>
                        <tr class="bg_ef">
                            <td class="txt-giai"> Giải 6 </td>
                            <td class="v-giai number">
                                <span class="v-g6-0 " data-nc="3"> 866 </span>
                                <span class="v-g6-1 " data-nc="3"> 403 </span>
                                <span class="v-g6-2 " data-nc="3"> 681 </span>
                            </td>
                        </tr>
                        <tr class="g7">
                            <td class="txt-giai"> Giải 7 </td>
                            <td class="v-giai number">
                                <span class="v-g7-0 " data-nc="2"> 87 </span>
                                <span class="v-g7-1 " data-nc="2"> 46 </span>
                                <span class="v-g7-2 " data-nc="2"> 22 </span>
                                <span class="v-g7-3 " data-nc="2"> 06 </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="control-panel">
                    <form class="digits-form">
                        <label class="radio" data-value="0">
                            <input name="showed-digits" type="radio" value="0">
                            <b>
                            </b>
                            <span>
                            </span>
                            </input>
                        </label>
                        <label class="radio" data-value="2">
                            <input name="showed-digits" type="radio" value="2">
                            <b>
                            </b>
                            <span>
                            </span>
                            </input>
                        </label>
                        <label class="radio" data-value="3">
                            <input name="showed-digits" type="radio" value="3">
                            <b>
                            </b>
                            <span>
                            </span>
                            </input>
                        </label>
                    </form>
                    <div class="buttons-wrapper">
                        <span class="zoom-in-button">
                            <i class="icon zoom-in-icon">
                            </i>
                            <span>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="txt-center ads">
                <div class="center ads">
                    <a class="banner-link" data-pos="banner_square" href="https://xoso.me/redirect/out?token=I%2FZxoQFsuUjDev87POoC9PSveDZOsQOylNFoAc3oAoA%3D" rel="nofollow" target="_blank" title="">
                        <img src="theme/frontend/images/300x250-14.jpg" />
                    </a>
                </div>
            </div>
            <script>
            </script>
            <div class="col-firstlast" data-id="dd">
                <table class="firstlast-mb fl">
                    <tbody>
                        <tr class="header">
                            <th> Đầu </th>
                            <th> Đuôi </th>
                        </tr>
                        <tr>
                            <td class="clnote"> 0 </td>
                            <td class="v-loto-dau-0"> 3,3,6 </td>
                        </tr>
                        <tr>
                            <td class="clnote"> 1 </td>
                            <td class="v-loto-dau-1"> 0,8,9 </td>
                        </tr>
                        <tr>
                            <td class="clnote"> 2 </td>
                            <td class="v-loto-dau-2"> 2,4,6,9,9 </td>
                        </tr>
                        <tr>
                            <td class="clnote"> 3 </td>
                            <td class="v-loto-dau-3"> 2,6 </td>
                        </tr>
                        <tr>
                            <td class="clnote"> 4 </td>
                            <td class="v-loto-dau-4"> 1,6,6 </td>
                        </tr>
                        <tr>
                            <td class="clnote"> 5 </td>
                            <td class="v-loto-dau-5"> 5,9 </td>
                        </tr>
                        <tr>
                            <td class="clnote"> 6 </td>
                            <td class="v-loto-dau-6"> 4,6,7,7 </td>
                        </tr>
                        <tr>
                            <td class="clnote"> 7 </td>
                            <td class="v-loto-dau-7">
                            </td>
                        </tr>
                        <tr>
                            <td class="clnote"> 8 </td>
                            <td class="v-loto-dau-8"> 0,1,7 </td>
                        </tr>
                        <tr>
                            <td class="clnote"> 9 </td>
                            <td class="v-loto-dau-9"> 0, <span class="clnote"> 3 </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="firstlast-mb fr">
                    <tbody>
                        <tr class="header">
                            <th> Đầu </th>
                            <th> Đuôi </th>
                        </tr>
                        <tr>
                            <td class="v-loto-duoi-0"> 1,8,9 </td>
                            <td class="clnote"> 0 </td>
                        </tr>
                        <tr>
                            <td class="v-loto-duoi-1"> 4,8 </td>
                            <td class="clnote"> 1 </td>
                        </tr>
                        <tr>
                            <td class="v-loto-duoi-2"> 2,3 </td>
                            <td class="clnote"> 2 </td>
                        </tr>
                        <tr>
                            <td class="v-loto-duoi-3"> 0,0, <span class="clnote"> 9 </span>
                            </td>
                            <td class="clnote"> 3 </td>
                        </tr>
                        <tr>
                            <td class="v-loto-duoi-4"> 2,6 </td>
                            <td class="clnote"> 4 </td>
                        </tr>
                        <tr>
                            <td class="v-loto-duoi-5"> 5 </td>
                            <td class="clnote"> 5 </td>
                        </tr>
                        <tr>
                            <td class="v-loto-duoi-6"> 0,2,3,4,4,6 </td>
                            <td class="clnote"> 6 </td>
                        </tr>
                        <tr>
                            <td class="v-loto-duoi-7"> 6,6,8 </td>
                            <td class="clnote"> 7 </td>
                        </tr>
                        <tr>
                            <td class="v-loto-duoi-8"> 1 </td>
                            <td class="clnote"> 8 </td>
                        </tr>
                        <tr>
                            <td class="v-loto-duoi-9"> 1,2,2,5 </td>
                            <td class="clnote"> 9 </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="clearfix">
            </div>
            <div class="bg_brown clearfix">
                <a class="conect_out " href="https://xoso.me/in-ve-do.html" rel="nofollow" title="In vé dò">
                    In vé dò </a>
            </div>
        </div>
        <div class="see-more">
            <div class="bold see-more-title"> ⇒ Ngoài ra bạn có thể xem thêm: </div>
            <ul class="list-html-link two-column">
                <li> Xem thêm <a href="https://xoso.me/thong-ke-giai-dac-biet-xo-so-mien-bac-xsmb.html" title="thống kê giải đặc biệt miền Bắc"> thống kê giải đặc biệt miền Bắc </a>
                </li>
                <li> Xem cao thủ <a href="https://xoso.me/du-doan-ket-qua-xo-so-mien-bac-xsmb-c228.html" title="dự đoán XSMB"> dự đoán XSMB </a> hôm nay </li>
                <li> Xem soi <a href="https://xoso.me/soi-cau-bach-thu-lo-to-xsmb-hom-nay.html" title="cầu bạch thủ miền Bắc"> cầu bạch thủ miền Bắc </a>
                </li>
                <li> Tham gia <a href="https://xoso.me/quay-thu-xsmb-quay-thu-xo-so-mien-bac.html" title="quay thử XSMB hôm nay"> quay thử XSMB hôm nay </a> để thử vận may </li>
                <li> Xem bảng <a href="https://xoso.me/xsmb-30-ngay-so-ket-qua-xo-so-kien-thiet-mien-bac.html" title="sổ kết quả XSMB"> sổ kết quả XSMB </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="box">
        <h2 class="tit-mien clearfix">
            <strong>
                <a class="title-a" href="https://xoso.me/xsmn-sxmn-kqxsmn-ket-qua-xo-so-mien-nam.html" title="XSMN"> XSMN </a> » <a class="title-a" href="https://xoso.me/xsmn-thu-3-sxmn-ket-qua-xo-so-mien-nam-thu-3.html" title="XSMN thứ 3"> XSMN thứ 3 </a> » <a class="title-a" href="https://xoso.me/xsmn-19-7-2022-ket-qua-xo-so-mien-nam-ngay-19-7-2022.html" title="XSMN 19-7-2022"> XSMN 19-7-2022 </a>
            </strong>
        </h2>
        <div id="load_kq_mn_0">
            <div class="three-city" data-id="kq" data-region="3">
                <table class="colthreecity colgiai extendable">
                    <tbody>
                        <tr class="gr-yellow">
                            <th class="first">
                            </th>
                            <th data-pid="4">
                                <a class="underline bold" href="https://xoso.me/mien-nam/xsbt-ket-qua-xo-so-ben-tre-p4.html" title="Xổ số Bến Tre"> Bến Tre </a>
                            </th>
                            <th data-pid="22">
                                <a class="underline bold" href="https://xoso.me/mien-nam/xsvt-ket-qua-xo-so-vung-tau-p22.html" title="Xổ số Vũng Tàu"> Vũng Tàu </a>
                            </th>
                            <th data-pid="3">
                                <a class="underline bold" href="https://xoso.me/mien-nam/xsbl-ket-qua-xo-so-bac-lieu-p3.html" title="Xổ số Bạc Liêu"> Bạc Liêu </a>
                            </th>
                        </tr>
                        <tr class="g8">
                            <td> G8 </td>
                            <td>
                                <div class="v-g8 " data-nc="2"> 20 </div>
                            </td>
                            <td>
                                <div class="v-g8 " data-nc="2"> 09 </div>
                            </td>
                            <td>
                                <div class="v-g8 " data-nc="2"> 04 </div>
                            </td>
                        </tr>
                        <tr>
                            <td> G7 </td>
                            <td>
                                <div class="v-g7 " data-nc="3"> 270 </div>
                            </td>
                            <td>
                                <div class="v-g7 " data-nc="3"> 729 </div>
                            </td>
                            <td>
                                <div class="v-g7 " data-nc="3"> 264 </div>
                            </td>
                        </tr>
                        <tr>
                            <td> G6 </td>
                            <td>
                                <div class="v-g6-0 " data-nc="4"> 8177 </div>
                                <div class="v-g6-1 " data-nc="4"> 0967 </div>
                                <div class="v-g6-2 " data-nc="4"> 5157 </div>
                            </td>
                            <td>
                                <div class="v-g6-0 " data-nc="4"> 1032 </div>
                                <div class="v-g6-1 " data-nc="4"> 1626 </div>
                                <div class="v-g6-2 " data-nc="4"> 9500 </div>
                            </td>
                            <td>
                                <div class="v-g6-0 " data-nc="4"> 5119 </div>
                                <div class="v-g6-1 " data-nc="4"> 9075 </div>
                                <div class="v-g6-2 " data-nc="4"> 6534 </div>
                            </td>
                        </tr>
                        <tr>
                            <td> G5 </td>
                            <td>
                                <div class="v-g5 " data-nc="4"> 0999 </div>
                            </td>
                            <td>
                                <div class="v-g5 " data-nc="4"> 8819 </div>
                            </td>
                            <td>
                                <div class="v-g5 " data-nc="4"> 8752 </div>
                            </td>
                        </tr>
                        <tr>
                            <td> G4 </td>
                            <td>
                                <div class="v-g4-0 " data-nc="5"> 30227 </div>
                                <div class="v-g4-1 " data-nc="5"> 72906 </div>
                                <div class="v-g4-2 " data-nc="5"> 36485 </div>
                                <div class="v-g4-3 " data-nc="5"> 55277 </div>
                                <div class="v-g4-4 " data-nc="5"> 25442 </div>
                                <div class="v-g4-5 " data-nc="5"> 89374 </div>
                                <div class="v-g4-6 " data-nc="5"> 13767 </div>
                            </td>
                            <td>
                                <div class="v-g4-0 " data-nc="5"> 82454 </div>
                                <div class="v-g4-1 " data-nc="5"> 33323 </div>
                                <div class="v-g4-2 " data-nc="5"> 92279 </div>
                                <div class="v-g4-3 " data-nc="5"> 96755 </div>
                                <div class="v-g4-4 " data-nc="5"> 24029 </div>
                                <div class="v-g4-5 " data-nc="5"> 64820 </div>
                                <div class="v-g4-6 " data-nc="5"> 83425 </div>
                            </td>
                            <td>
                                <div class="v-g4-0 " data-nc="5"> 24975 </div>
                                <div class="v-g4-1 " data-nc="5"> 67801 </div>
                                <div class="v-g4-2 " data-nc="5"> 73656 </div>
                                <div class="v-g4-3 " data-nc="5"> 48413 </div>
                                <div class="v-g4-4 " data-nc="5"> 01116 </div>
                                <div class="v-g4-5 " data-nc="5"> 33275 </div>
                                <div class="v-g4-6 " data-nc="5"> 46552 </div>
                            </td>
                        </tr>
                        <tr>
                            <td> G3 </td>
                            <td>
                                <div class="v-g3-0 " data-nc="5"> 63356 </div>
                                <div class="v-g3-1 " data-nc="5"> 62332 </div>
                            </td>
                            <td>
                                <div class="v-g3-0 " data-nc="5"> 24053 </div>
                                <div class="v-g3-1 " data-nc="5"> 79376 </div>
                            </td>
                            <td>
                                <div class="v-g3-0 " data-nc="5"> 17505 </div>
                                <div class="v-g3-1 " data-nc="5"> 03554 </div>
                            </td>
                        </tr>
                        <tr>
                            <td> G2 </td>
                            <td>
                                <div class="v-g2 " data-nc="5"> 79217 </div>
                            </td>
                            <td>
                                <div class="v-g2 " data-nc="5"> 75427 </div>
                            </td>
                            <td>
                                <div class="v-g2 " data-nc="5"> 90274 </div>
                            </td>
                        </tr>
                        <tr>
                            <td> G1 </td>
                            <td>
                                <div class="v-g1 " data-nc="5"> 06063 </div>
                            </td>
                            <td>
                                <div class="v-g1 " data-nc="5"> 17941 </div>
                            </td>
                            <td>
                                <div class="v-g1 " data-nc="5"> 27421 </div>
                            </td>
                        </tr>
                        <tr class="gdb">
                            <td> ĐB </td>
                            <td>
                                <div class="v-gdb " data-nc="6"> 352727 </div>
                            </td>
                            <td>
                                <div class="v-gdb " data-nc="6"> 437014 </div>
                            </td>
                            <td>
                                <div class="v-gdb " data-nc="6"> 800636 </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="control-panel">
                    <form class="digits-form">
                        <label class="radio" data-value="0">
                            <input name="showed-digits" type="radio" value="0">
                            <b>
                            </b>
                            <span>
                            </span>
                            </input>
                        </label>
                        <label class="radio" data-value="2">
                            <input name="showed-digits" type="radio" value="2">
                            <b>
                            </b>
                            <span>
                            </span>
                            </input>
                        </label>
                        <label class="radio" data-value="3">
                            <input name="showed-digits" type="radio" value="3">
                            <b>
                            </b>
                            <span>
                            </span>
                            </input>
                        </label>
                    </form>
                    <div class="buttons-wrapper">
                        <span class="zoom-in-button">
                            <i class="icon zoom-in-icon">
                            </i>
                            <span>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-firstlast colthreecity colgiai" data-id="dd">
                <table class="firstlast-mn bold">
                    <tbody>
                        <tr class="header">
                            <th class="first"> Đầu </th>
                            <th> Bến Tre </th>
                            <th> Vũng Tàu </th>
                            <th> Bạc Liêu </th>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 0 </td>
                            <td class="v-loto-dau-0"> 6 </td>
                            <td class="v-loto-dau-0"> 0,9 </td>
                            <td class="v-loto-dau-0"> 1,4,5 </td>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 1 </td>
                            <td class="v-loto-dau-1"> 7 </td>
                            <td class="v-loto-dau-1">
                                <span class="clred"> 4 </span> ,9
                            </td>
                            <td class="v-loto-dau-1"> 3,6,9 </td>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 2 </td>
                            <td class="v-loto-dau-2"> 0, <span class="clred"> 7 </span> ,7 </td>
                            <td class="v-loto-dau-2"> 0,3,5,6,7,9,9 </td>
                            <td class="v-loto-dau-2"> 1 </td>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 3 </td>
                            <td class="v-loto-dau-3"> 2 </td>
                            <td class="v-loto-dau-3"> 2 </td>
                            <td class="v-loto-dau-3"> 4, <span class="clred"> 6 </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 4 </td>
                            <td class="v-loto-dau-4"> 2 </td>
                            <td class="v-loto-dau-4"> 1 </td>
                            <td class="v-loto-dau-4">
                            </td>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 5 </td>
                            <td class="v-loto-dau-5"> 6,7 </td>
                            <td class="v-loto-dau-5"> 3,4,5 </td>
                            <td class="v-loto-dau-5"> 2,2,4,6 </td>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 6 </td>
                            <td class="v-loto-dau-6"> 3,7,7 </td>
                            <td class="v-loto-dau-6">
                            </td>
                            <td class="v-loto-dau-6"> 4 </td>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 7 </td>
                            <td class="v-loto-dau-7"> 0,4,7,7 </td>
                            <td class="v-loto-dau-7"> 6,9 </td>
                            <td class="v-loto-dau-7"> 4,5,5,5 </td>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 8 </td>
                            <td class="v-loto-dau-8"> 5 </td>
                            <td class="v-loto-dau-8">
                            </td>
                            <td class="v-loto-dau-8">
                            </td>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 9 </td>
                            <td class="v-loto-dau-9"> 9 </td>
                            <td class="v-loto-dau-9">
                            </td>
                            <td class="v-loto-dau-9">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="see-more">
            <div class="bold see-more-title"> ⇒ Ngoài ra bạn có thể xem thêm: </div>
            <ul class="list-html-link">
                <li> Xem thêm <a href="https://xoso.me/lo-gan-mn-thong-ke-lo-gan-mien-nam.html" title="thống kê lô gan miền Nam"> thống kê lô gan miền Nam </a>
                </li>
                <li> Xem cao thủ <a href="https://xoso.me/du-doan-ket-qua-xo-so-mien-nam-xsmn-c226.html" title="dự đoán XSMN"> dự đoán XSMN </a> hôm nay siêu chính xác </li>
                <li> Tham gia <a href="https://xoso.me/quay-thu-xsmn-quay-thu-xo-so-mien-nam.html" title="quay thử XSMN hôm nay"> quay thử XSMN hôm nay </a>
                </li>
                <li> Xem bảng kết quả <a href="https://xoso.me/xsmn-30-ngay-so-ket-qua-xo-so-kien-thiet-mien-nam.html" title="xổ số miền Nam 30 ngày"> xổ số miền Nam 30 ngày </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="box">
        <h2 class="tit-mien clearfix">
            <strong>
                <a class="title-a" href="https://xoso.me/xsmt-sxmt-kqxsmt-ket-qua-xo-so-mien-trung.html" title="XSMT"> XSMT </a> » <a class="title-a" href="https://xoso.me/xsmt-thu-3-sxmt-ket-qua-xo-so-mien-trung-thu-3.html" title="XSMT thứ 3"> XSMT thứ 3 </a> » <a class="title-a" href="https://xoso.me/xsmt-19-7-2022-ket-qua-xo-so-mien-trung-ngay-19-7-2022.html" title="XSMT 19-7-2022"> XSMT 19-7-2022 </a>
            </strong>
        </h2>
        <div id="load_kq_mt_0">
            <div class="two-city" data-id="kq" data-region="2">
                <table class="coltwocity colgiai extendable">
                    <tbody>
                        <tr class="gr-yellow">
                            <th class="first">
                            </th>
                            <th data-pid="25">
                                <a class="underline bold" href="https://xoso.me/mien-trung/xsdlk-ket-qua-xo-so-dac-lac-p25.html" title="XSDLK"> Đắc Lắc </a>
                            </th>
                            <th data-pid="34">
                                <a class="underline bold" href="https://xoso.me/mien-trung/xsqnm-ket-qua-xo-so-quang-nam-p34.html" title="XSQNM"> Quảng Nam </a>
                            </th>
                        </tr>
                        <tr class="g8">
                            <td> G8 </td>
                            <td>
                                <div class="v-g8 " data-nc="2"> 99 </div>
                            </td>
                            <td>
                                <div class="v-g8 " data-nc="2"> 37 </div>
                            </td>
                        </tr>
                        <tr>
                            <td> G7 </td>
                            <td>
                                <div class="v-g7 " data-nc="3"> 133 </div>
                            </td>
                            <td>
                                <div class="v-g7 " data-nc="3"> 109 </div>
                            </td>
                        </tr>
                        <tr>
                            <td> G6 </td>
                            <td>
                                <div class="v-g6-0 " data-nc="4"> 4299 </div>
                                <div class="v-g6-1 " data-nc="4"> 1260 </div>
                                <div class="v-g6-2 " data-nc="4"> 1967 </div>
                            </td>
                            <td>
                                <div class="v-g6-0 " data-nc="4"> 3834 </div>
                                <div class="v-g6-1 " data-nc="4"> 5123 </div>
                                <div class="v-g6-2 " data-nc="4"> 5516 </div>
                            </td>
                        </tr>
                        <tr>
                            <td> G5 </td>
                            <td>
                                <div class="v-g5 " data-nc="4"> 1016 </div>
                            </td>
                            <td>
                                <div class="v-g5 " data-nc="4"> 2736 </div>
                            </td>
                        </tr>
                        <tr>
                            <td> G4 </td>
                            <td>
                                <div class="v-g4-0 " data-nc="5"> 96763 </div>
                                <div class="v-g4-1 " data-nc="5"> 16441 </div>
                                <div class="v-g4-2 " data-nc="5"> 60862 </div>
                                <div class="v-g4-3 " data-nc="5"> 61705 </div>
                                <div class="v-g4-4 " data-nc="5"> 54047 </div>
                                <div class="v-g4-5 " data-nc="5"> 37870 </div>
                                <div class="v-g4-6 " data-nc="5"> 11415 </div>
                            </td>
                            <td>
                                <div class="v-g4-0 " data-nc="5"> 11886 </div>
                                <div class="v-g4-1 " data-nc="5"> 56508 </div>
                                <div class="v-g4-2 " data-nc="5"> 66677 </div>
                                <div class="v-g4-3 " data-nc="5"> 37405 </div>
                                <div class="v-g4-4 " data-nc="5"> 85103 </div>
                                <div class="v-g4-5 " data-nc="5"> 40266 </div>
                                <div class="v-g4-6 " data-nc="5"> 38869 </div>
                            </td>
                        </tr>
                        <tr>
                            <td> G3 </td>
                            <td>
                                <div class="v-g3-0 " data-nc="5"> 31628 </div>
                                <div class="v-g3-1 " data-nc="5"> 19537 </div>
                            </td>
                            <td>
                                <div class="v-g3-0 " data-nc="5"> 79660 </div>
                                <div class="v-g3-1 " data-nc="5"> 48664 </div>
                            </td>
                        </tr>
                        <tr>
                            <td> G2 </td>
                            <td>
                                <div class="v-g2 " data-nc="5"> 44322 </div>
                            </td>
                            <td>
                                <div class="v-g2 " data-nc="5"> 45742 </div>
                            </td>
                        </tr>
                        <tr>
                            <td> G1 </td>
                            <td>
                                <div class="v-g1 " data-nc="5"> 51008 </div>
                            </td>
                            <td>
                                <div class="v-g1 " data-nc="5"> 88571 </div>
                            </td>
                        </tr>
                        <tr class="gdb">
                            <td> ĐB </td>
                            <td>
                                <div class="v-gdb " data-nc="6"> 943620 </div>
                            </td>
                            <td>
                                <div class="v-gdb " data-nc="6"> 336712 </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="control-panel">
                    <form class="digits-form">
                        <label class="radio" data-value="0">
                            <input name="showed-digits" type="radio" value="0">
                            <b>
                            </b>
                            <span>
                            </span>
                            </input>
                        </label>
                        <label class="radio" data-value="2">
                            <input name="showed-digits" type="radio" value="2">
                            <b>
                            </b>
                            <span>
                            </span>
                            </input>
                        </label>
                        <label class="radio" data-value="3">
                            <input name="showed-digits" type="radio" value="3">
                            <b>
                            </b>
                            <span>
                            </span>
                            </input>
                        </label>
                    </form>
                    <div class="buttons-wrapper">
                        <span class="zoom-in-button">
                            <i class="icon zoom-in-icon">
                            </i>
                            <span>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-firstlast coltwocity colgiai" data-id="dd">
                <table class="firstlast-mn bold">
                    <tbody>
                        <tr class="header">
                            <th class="first"> Đầu </th>
                            <th> Đắc Lắc </th>
                            <th> Quảng Nam </th>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 0 </td>
                            <td class="v-loto-dau-0"> 5,8 </td>
                            <td class="v-loto-dau-0"> 3,5,8,9 </td>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 1 </td>
                            <td class="v-loto-dau-1"> 5,6 </td>
                            <td class="v-loto-dau-1">
                                <span class="clred"> 2 </span> ,6
                            </td>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 2 </td>
                            <td class="v-loto-dau-2">
                                <span class="clred"> 0 </span> ,2,8
                            </td>
                            <td class="v-loto-dau-2"> 3 </td>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 3 </td>
                            <td class="v-loto-dau-3"> 3,7 </td>
                            <td class="v-loto-dau-3"> 4,6,7 </td>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 4 </td>
                            <td class="v-loto-dau-4"> 1,7 </td>
                            <td class="v-loto-dau-4"> 2 </td>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 5 </td>
                            <td class="v-loto-dau-5">
                            </td>
                            <td class="v-loto-dau-5">
                            </td>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 6 </td>
                            <td class="v-loto-dau-6"> 0,2,3,7 </td>
                            <td class="v-loto-dau-6"> 0,4,6,9 </td>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 7 </td>
                            <td class="v-loto-dau-7"> 0 </td>
                            <td class="v-loto-dau-7"> 1,7 </td>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 8 </td>
                            <td class="v-loto-dau-8">
                            </td>
                            <td class="v-loto-dau-8"> 6 </td>
                        </tr>
                        <tr>
                            <td class="clnote bold"> 9 </td>
                            <td class="v-loto-dau-9"> 9,9 </td>
                            <td class="v-loto-dau-9">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="see-more">
            <div class="bold see-more-title"> ⇒ Ngoài ra bạn có thể xem thêm: </div>
            <ul class="list-html-link two-column">
                <li> Xem thêm <a href="https://xoso.me/lo-gan-mt-thong-ke-lo-gan-mien-trung.html" title="thống kê lô gan miền Trung"> thống kê lô gan miền Trung </a>
                </li>
                <li> Xem cao thủ <a href="https://xoso.me/du-doan-ket-qua-xo-so-mien-trung-xsmt-c224.html" title="dự đoán XSMT"> dự đoán XSMT </a> siêu chuẩn </li>
                <li> Tham gia <a href="https://xoso.me/quay-thu-xsmt-quay-thu-xo-so-mien-trung.html" title="quay thử XSMT hôm nay"> quay thử XSMT hôm nay </a> thử vận may </li>
                <li> Xem bảng <a href="https://xoso.me/xsmt-30-ngay-so-ket-qua-xo-so-kien-thiet-mien-trung.html" title="kết quả xổ số miền Trung 30 ngày"> kết quả xổ số miền Trung 30 ngày </a>
                </li>
            </ul>
        </div>
    </div>
    {!!App\Models\StaticalCrawl::getBoxVietlottContentHome()!!}
    <div class="box box-html">
        {[home_content]}
    </div>
</div>
@endsection