@extends('index')
@section('main')
<div class="box-detail box">
    <div class="search-dream bg_f9">
        <div class="box-search clearfix">
            <form id="w0" action="https://xoso.me/so-mo-lo-de-mien-bac-so-mo-giai-mong.html" method="post">
                <input type="hidden" name="_csrf" value="PjhtUBIipapCrEMfo8DI3CvCY9lHOjkzuJ0Ew5E4PN9GSV8_IUP__AHuGWz594qdUZcJlAF1TWTi1HS6_W9rlg==">
                <span class="bor-1 fl">
                    <input name="tukhoa" type="search" value="">
                </span>
                <button class="fl" type="submit">
                    <strong>Tìm kiếm</strong>
                </button>
            </form>
        </div>
        <h1 class="font-20 bold pad5">{{Support::show($currentItem,'name')}}</h1>
        <div class="table-dream">
            <table class="bold">
                <thead>
                    <tr>
                        <th>Bạn mơ thấy gì</th>
                        <th>Cặp số tương ứng</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>3 con rắn</td>
                        <td>13, 31, 40</td>
                    </tr>
                </tbody>
            </table>
            <div class="cont-dream s-content pad10-5 cont-detail paragraph">
                {!!Support::show($currentItem,'content')!!}
            </div>
        </div>
    </div>
    <div class="see-more ">
        <h3 class="tit-mien">
            <strong>Các giấc mơ xem nhiều</strong>
        </h3>
        <ul class="list-html-link two-column">
            <li>
                <a href="https://xoso.me/mo-thay-con-bo-d335.html" title="Mơ thấy con bò – Chiêm bao thấy con bò đánh con gì?">Mơ thấy con bò – Chiêm bao thấy con bò đánh con gì?</a>
            </li>
            <li>
                <a href="https://xoso.me/mo-thay-nguoi-chet-d829.html" title="Mơ thấy người chết - Chiêm bao thấy người chết đánh con gì?">Mơ thấy người chết - Chiêm bao thấy người chết đánh con gì?</a>
            </li>
            <li>
                <a href="https://xoso.me/mo-thay-noi-chuyen-voi-nguoi-da-chet-d891.html" title="Mơ thấy nói chuyện với người chết - Chiêm bao nói chuyện với người chết">Mơ thấy nói chuyện với người chết - Chiêm bao nói chuyện với người chết</a>
            </li>
            <li>
                <a href="https://xoso.me/mo-thay-xe-o-to-d1169.html" title="Nằm mơ thấy ô tô đánh con gì? Chiêm bao thấy xe ô tô báo điềm gì?">Nằm mơ thấy ô tô đánh con gì? Chiêm bao thấy xe ô tô báo điềm gì?</a>
            </li>
            <li>
                <a href="https://xoso.me/mo-thay-dam-cuoi-d432.html" title="Mơ thấy đám cưới – Chiêm bao thấy đám cưới đánh con gì?">Mơ thấy đám cưới – Chiêm bao thấy đám cưới đánh con gì?</a>
            </li>
            <li>
                <a href="https://xoso.me/mo-thay-trung-d1224.html" title="Mơ thấy trứng -  Chiêm bao thấy trứng đánh con gì?">Mơ thấy trứng - Chiêm bao thấy trứng đánh con gì?</a>
            </li>
            <li>
                <a href="https://xoso.me/mo-thay-ngu-voi-gai-d821.html" title="Mơ thấy ngủ với gái – Chiêm bao thấy ngủ với gái đánh con gì?">Mơ thấy ngủ với gái – Chiêm bao thấy ngủ với gái đánh con gì?</a>
            </li>
            <li>
                <a href="https://xoso.me/mo-thay-so-de-d1244.html" title="Mơ thấy số đề - Chiêm bao số đề đánh con gì?">Mơ thấy số đề - Chiêm bao số đề đánh con gì?</a>
            </li>
            <li>
                <a href="https://xoso.me/mo-thay-chay-nha-d268.html" title="Mơ thấy cháy nhà – Chiêm bao thấy cháy nhà đánh con gì?">Mơ thấy cháy nhà – Chiêm bao thấy cháy nhà đánh con gì?</a>
            </li>
            <li>
                <a href="https://xoso.me/mo-thay-mo-thay-bo-d762.html" title="Mơ thấy bố – Chiêm bao thấy bố đánh con gì chuẩn nhất?">Mơ thấy bố – Chiêm bao thấy bố đánh con gì chuẩn nhất?</a>
            </li>
        </ul>
    </div>
    <div class="box sugges-dream">
        <h2 class="tit-mien">
            <strong>Gợi ý mơ thấy</strong>
        </h2>
        <table class="">
            <tbody>
                <tr>
                    <td>
                        <a href="https://xoso.me/mo-thay-am-ho-d7.html" title="âm hộ">
                            <strong class="clred">âm hộ</strong>
                        </a>
                    </td>
                    <td>
                        <strong class="cl-green">17, 71, 21</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="https://xoso.me/mo-thay-an-ai-d8.html" title="ân ái">
                            <strong class="clred">ân ái</strong>
                        </a>
                    </td>
                    <td>
                        <strong class="cl-green">25, 75</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="https://xoso.me/mo-thay-an-cap-xe-dap-d10.html" title="ăn cắp xe đạp">
                            <strong class="clred">ăn cắp xe đạp</strong>
                        </a>
                    </td>
                    <td>
                        <strong class="cl-green">34</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="https://xoso.me/mo-thay-an-chay-d11.html" title="ăn chay">
                            <strong class="clred">ăn chay</strong>
                        </a>
                    </td>
                    <td>
                        <strong class="cl-green">86, 85</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="https://xoso.me/mo-thay-an-chua-d12.html" title="ăn chua">
                            <strong class="clred">ăn chua</strong>
                        </a>
                    </td>
                    <td>
                        <strong class="cl-green">93, 39</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="see-more">
        <h3 class="tit-mien">
            <strong>Xem thêm tiện ích dưới đây</strong>
        </h3>
        <ul class="list-html-link two-column">
            <li>Xem thêm <a href="/xsmb-sxmb-xstd-xshn-kqxsmb-ket-qua-xo-so-mien-bac.html" title="Kết quả xổ số miền Bắc hôm nay">kết quả xổ số miền Bắc hôm nay</a>
            </li>
            <li>Xem thêm <a href="/thong-ke-lo-gan-xo-so-mien-bac-xsmb.html" title="Thống kê lô gan">thống kê lô gan miền Bắc</a>
            </li>
            <li>Xem cao thủ <a href="https://xoso.me/du-doan-ket-qua-xo-so-mien-bac-xsmb-c228.html" title="Dự đoán XSMB">dự đoán XSMB</a> hôm nay chính xác nhất </li>
            <li>Xem thêm <a href="/thong-ke-giai-dac-biet-xo-so-mien-bac-xsmb.html" title="thống kê giải đặc biệt miền Bắc">thống kê giải đặc biệt miền Bắc</a>
            </li>
            <li>Xem thêm <a href="https://xoso.me/quay-thu-xsmb-quay-thu-xo-so-mien-bac.html" title="quay thử xổ số miền Bắc">quay thử xổ số miền Bắc</a>
            </li>
        </ul>
    </div>
</div>
<div class="box box-comment">
    
</div>
@endsection