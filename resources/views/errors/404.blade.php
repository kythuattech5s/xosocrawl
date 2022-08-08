@extends('index')
@section('main')
<div class="content">
    <div class="main clearfix">
       <style>
          .add_zero {
          background: #FFFDDC;
          border: 1px solid #f2f2f2;
          padding: 5px 4px;
          text-align: center;
          }
          .mss_expired h3, .mss_del h3, .add_zero h3 {margin:0;padding:15px 0 15px 10px;font-size:18px}
       </style>
       <div class="add_zero">
          <p>Địa chỉ mà bạn vừa truy cập không tồn tại, Vui lòng quay về <a class="clnote" href="/" title="xoso.me"><strong>Trang chủ</strong></a></p>
       </div>
       <div class="box-dream box">
          <h2 class="tit-mien"><strong>Lịch quay xổ số các tỉnh trong tuần</strong></h2>
          <div class="calendar">
             <table class="colgiai">
                <tbody>
                   <tr>
                      <th>
                         <strong>Miền bắc</strong>
                      </th>
                      <th><strong>Miền nam</strong></th>
                      <th><strong>Miền trung</strong></th>
                   </tr>
                   <tr>
                      <td>
                         <span class="dspblock pad5"> <a class="sub-title" title="XSMB thứ 2" href="/xsmb-thu-2-ket-qua-xo-so-mien-bac-thu-2.html">XSMB thứ 2</a></span>
                      </td>
                      <td>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số TP Hồ Chí Minh" href="/mien-nam/xshcm-ket-qua-xo-so-thanh-pho-ho-chi-minh-p14.html">TP Hồ Chí Minh</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Đồng Tháp" href="/mien-nam/xsdt-ket-qua-xo-so-dong-thap-p12.html">Đồng Tháp</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Cà Mau" href="/mien-nam/xscm-ket-qua-xo-so-ca-mau-p8.html">Cà Mau</a></span>
                      </td>
                      <td>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Thừa Thiên Huế" href="/mien-trung/xstth-ket-qua-xo-so-thua-thien-hue-p36.html">Thừa Thiên Huế</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Phú Yên" href="/mien-trung/xspy-ket-qua-xo-so-phu-yen-p31.html">Phú Yên</a></span>
                      </td>
                   </tr>
                   <tr>
                      <td>
                         <span class="dspblock pad5"> <a class="sub-title" title="XSMB thứ 3" href="/xsmb-thu-3-ket-qua-xo-so-mien-bac-thu-3.html">XSMB thứ 3</a></span>
                      </td>
                      <td>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Bến Tre" href="/mien-nam/xsbt-ket-qua-xo-so-ben-tre-p4.html">Bến Tre</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Vũng Tàu" href="/mien-nam/xsvt-ket-qua-xo-so-vung-tau-p22.html">Vũng Tàu</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Bạc Liêu" href="/mien-nam/xsbl-ket-qua-xo-so-bac-lieu-p3.html">Bạc Liêu</a></span>
                      </td>
                      <td>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Đắc Lắc" href="/mien-trung/xsdlk-ket-qua-xo-so-dac-lac-p25.html">Đắc Lắc</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Quảng Nam" href="/mien-trung/xsqnm-ket-qua-xo-so-quang-nam-p34.html">Quảng Nam</a></span>
                      </td>
                   </tr>
                   <tr>
                      <td>
                         <span class="dspblock pad5"> <a class="sub-title" title="XSMB thứ 4" href="/xsmb-thu-4-ket-qua-xo-so-mien-bac-thu-4.html">XSMB thứ 4</a></span>
                      </td>
                      <td>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Đồng Nai" href="/mien-nam/xsdn-ket-qua-xo-so-dong-nai-p11.html">Đồng Nai</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Cần Thơ" href="/mien-nam/xsct-ket-qua-xo-so-can-tho-p9.html">Cần Thơ</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Sóc Trăng" href="/mien-nam/xsst-ket-qua-xo-so-soc-trang-p17.html">Sóc Trăng</a></span>
                      </td>
                      <td>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Đà Nẵng" href="/mien-trung/xsdng-ket-qua-xo-so-da-nang-p24.html">Đà Nẵng</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Khánh Hòa" href="/mien-trung/xskh-ket-qua-xo-so-khanh-hoa-p28.html">Khánh Hòa</a></span>
                      </td>
                   </tr>
                   <tr>
                      <td>
                         <span class="dspblock pad5"> <a class="sub-title" title="XSMB thứ 5" href="/xsmb-thu-5-ket-qua-xo-so-mien-bac-thu-5.html">XSMB thứ 5</a></span>
                      </td>
                      <td>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Tây Ninh" href="/mien-nam/xstn-ket-qua-xo-so-tay-ninh-p18.html">Tây Ninh</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số An Giang" href="/mien-nam/xsag-ket-qua-xo-so-an-giang-p2.html">An Giang</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Bình Thuận" href="/mien-nam/xsbth-ket-qua-xo-so-binh-thuan-p7.html">Bình Thuận</a></span>
                      </td>
                      <td>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Bình Định" href="/mien-trung/xsbdi-ket-qua-xo-so-binh-dinh-p23.html">Bình Định</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Quảng Trị" href="/mien-trung/xsqt-ket-qua-xo-so-quang-tri-p35.html">Quảng Trị</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Quảng Bình" href="/mien-trung/xsqb-ket-qua-xo-so-quang-binh-p32.html">Quảng Bình</a></span>
                      </td>
                   </tr>
                   <tr>
                      <td>
                         <span class="dspblock pad5"> <a class="sub-title" title="XSMB thứ 6" href="/xsmb-thu-6-ket-qua-xo-so-mien-bac-thu-6.html">XSMB thứ 6</a></span>
                      </td>
                      <td>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Vĩnh Long" href="/mien-nam/xsvl-ket-qua-xo-so-vinh-long-p21.html">Vĩnh Long</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Bình Dương" href="/mien-nam/xsbd-ket-qua-xo-so-binh-duong-p5.html">Bình Dương</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Trà Vinh" href="/mien-nam/xstv-ket-qua-xo-so-tra-vinh-p20.html">Trà Vinh</a></span>
                      </td>
                      <td>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Gia Lai" href="/mien-trung/xsgl-ket-qua-xo-so-gia-lai-p27.html">Gia Lai</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Ninh Thuận" href="/mien-trung/xsnt-ket-qua-xo-so-ninh-thuan-p30.html">Ninh Thuận</a></span>
                      </td>
                   </tr>
                   <tr>
                      <td>
                         <span class="dspblock pad5"> <a class="sub-title" title="XSMB thứ 7" href="/xsmb-thu-7-ket-qua-xo-so-mien-bac-thu-7.html">XSMB thứ 7</a></span>
                      </td>
                      <td>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số TP Hồ Chí Minh" href="/mien-nam/xshcm-ket-qua-xo-so-thanh-pho-ho-chi-minh-p14.html">TP Hồ Chí Minh</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Long An" href="/mien-nam/xsla-ket-qua-xo-so-long-an-p16.html">Long An</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Bình Phước" href="/mien-nam/xsbp-ket-qua-xo-so-binh-phuoc-p6.html">Bình Phước</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Hậu Giang" href="/mien-nam/xshg-ket-qua-xo-so-hau-giang-p13.html">Hậu Giang</a></span>
                      </td>
                      <td>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Đà Nẵng" href="/mien-trung/xsdng-ket-qua-xo-so-da-nang-p24.html">Đà Nẵng</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Quảng Ngãi" href="/mien-trung/xsqng-ket-qua-xo-so-quang-ngai-p33.html">Quảng Ngãi</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Đắc Nông" href="/mien-trung/xsdno-ket-qua-xo-so-dac-nong-p26.html">Đắc Nông</a></span>
                      </td>
                   </tr>
                   <tr>
                      <td>
                         <span class="dspblock pad5"> <a class="sub-title" title="XSMB chủ nhật" href="/xsmb-chu-nhat-ket-qua-xo-so-mien-bac-chu-nhat.html">XSMB chủ nhật</a></span>
                      </td>
                      <td>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Tiền Giang" href="/mien-nam/xstg-ket-qua-xo-so-tien-giang-p19.html">Tiền Giang</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Kiên Giang" href="/mien-nam/xskg-ket-qua-xo-so-kien-giang-p15.html">Kiên Giang</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Đà Lạt" href="/mien-nam/xsdl-ket-qua-xo-so-da-lat-p10.html">Đà Lạt</a></span>
                      </td>
                      <td>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Khánh Hòa" href="/mien-trung/xskh-ket-qua-xo-so-khanh-hoa-p28.html">Khánh Hòa</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Kon Tum" href="/mien-trung/xskt-ket-qua-xo-so-kon-tum-p29.html">Kon Tum</a></span>
                         <span class="dspblock pad5"><a class="sub-title" title="Kết quả xổ số Thừa Thiên Huế" href="/mien-trung/xstth-ket-qua-xo-so-thua-thien-hue-p36.html">Thừa Thiên Huế</a></span>
                      </td>
                   </tr>
                </tbody>
             </table>
          </div>
       </div>
    </div>
 </div>
@endsection