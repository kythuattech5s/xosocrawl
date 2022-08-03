@extends('index')
@section('main')
@include('partials.link_du_doan')
    <div class="box">
       <div class="bg_gray">
          <div class=" opt_date_full clearfix">
            @php
                $prevLottoRecord = $lottoRecord->prev();
                $nextLottoRecord = $lottoRecord->next();
            @endphp
            @if($prevLottoRecord)
                <a href="{{$prevLottoRecord->link($linkPrefix)}}" class="ic-pre fl" title="Kết quả xổ số {{$prevLottoRecord->name}} ngày {{Support::format($prevLottoRecord->created_at)}}"></a>
            @endif
             <label><strong>{{Support::getDayOfWeek($lottoRecord->created_at)}}</strong> - <input type="text" class="nobor hasDatepicker" value="{{Support::format($lottoRecord->created_at)}}" id="searchDate"><span class="ic ic-calendar"></span></label>
             @if($nextLottoRecord)
             <a href="{{$nextLottoRecord->link($linkPrefix)}}" class="ic-next" title="Kết quả xổ số {{$nextLottoRecord->name}} ngày {{Support::format($nextLottoRecord->created_at)}}"></a>
             @endif
          </div>
       </div>
    </div>
    
    <div class="box">
       @include('xoso.breadcrumb')
       <div id="load_kq_tinh_0">
          <div data-id="kq" class="one-city" data-region="1">
            @include('xoso.result_table')
             <div class="control-panel">
                <form class="digits-form">
                   <label class="radio" data-value="0">
                   <input type="radio" name="showed-digits" value="0">
                   <b></b>
                   <span></span>
                   </label>
                   <label class="radio" data-value="2">
                   <input type="radio" name="showed-digits" value="2">
                   <b></b><span></span>
                   </label>
                   <label class="radio" data-value="3">
                   <input type="radio" name="showed-digits" value="3">
                   <b></b><span></span>
                   </label>
                </form>
                <div class="buttons-wrapper">
                   <span class="zoom-in-button"><i class="icon zoom-in-icon"></i>
                   <span></span>
                   </span>
                </div>
             </div>
          </div>
          <div class="txt-center ads">
             <div class="center ads">
                <a class="banner-link" href="/redirect/out?token=I%2FZxoQFsuUjDev87POoC9PSveDZOsQOylNFoAc3oAoA%3D" title="" rel="nofollow" target="_blank" data-pos="banner_square"><img src="https://cdn.xoso.me/images/other/300x250.png"></a> 
             </div>
          </div>
          <script></script>
          <div data-id="dd" class="col-firstlast">
             <table class="firstlast-mb fl">
                <tbody>
                   <tr class="header">
                      <th>Đầu</th>
                      <th>Đuôi</th>
                   </tr>
                   <tr>
                      <td class="clnote">0</td>
                      <td class="v-loto-dau-0">1,2</td>
                   </tr>
                   <tr>
                      <td class="clnote">1</td>
                      <td class="v-loto-dau-1">0,3,5</td>
                   </tr>
                   <tr>
                      <td class="clnote">2</td>
                      <td class="v-loto-dau-2">3,5</td>
                   </tr>
                   <tr>
                      <td class="clnote">3</td>
                      <td class="v-loto-dau-3">2,2,4,7</td>
                   </tr>
                   <tr>
                      <td class="clnote">4</td>
                      <td class="v-loto-dau-4">0,9</td>
                   </tr>
                   <tr>
                      <td class="clnote">5</td>
                      <td class="v-loto-dau-5">0,4,8</td>
                   </tr>
                   <tr>
                      <td class="clnote">6</td>
                      <td class="v-loto-dau-6">0,0,4,6</td>
                   </tr>
                   <tr>
                      <td class="clnote">7</td>
                      <td class="v-loto-dau-7">0,2,5,6</td>
                   </tr>
                   <tr>
                      <td class="clnote">8</td>
                      <td class="v-loto-dau-8"></td>
                   </tr>
                   <tr>
                      <td class="clnote">9</td>
                      <td class="v-loto-dau-9"><span class="clnote">0</span>,0,4</td>
                   </tr>
                </tbody>
             </table>
             <table class="firstlast-mb fr">
                <tbody>
                   <tr class="header">
                      <th>Đầu</th>
                      <th>Đuôi</th>
                   </tr>
                   <tr>
                      <td class="v-loto-duoi-0">1,4,5,6,6,7,<span class="clnote">9</span>,9</td>
                      <td class="clnote">0</td>
                   </tr>
                   <tr>
                      <td class="v-loto-duoi-1">0</td>
                      <td class="clnote">1</td>
                   </tr>
                   <tr>
                      <td class="v-loto-duoi-2">0,3,3,7</td>
                      <td class="clnote">2</td>
                   </tr>
                   <tr>
                      <td class="v-loto-duoi-3">1,2</td>
                      <td class="clnote">3</td>
                   </tr>
                   <tr>
                      <td class="v-loto-duoi-4">3,5,6,9</td>
                      <td class="clnote">4</td>
                   </tr>
                   <tr>
                      <td class="v-loto-duoi-5">1,2,7</td>
                      <td class="clnote">5</td>
                   </tr>
                   <tr>
                      <td class="v-loto-duoi-6">6,7</td>
                      <td class="clnote">6</td>
                   </tr>
                   <tr>
                      <td class="v-loto-duoi-7">3</td>
                      <td class="clnote">7</td>
                   </tr>
                   <tr>
                      <td class="v-loto-duoi-8">5</td>
                      <td class="clnote">8</td>
                   </tr>
                   <tr>
                      <td class="v-loto-duoi-9">4</td>
                      <td class="clnote">9</td>
                   </tr>
                </tbody>
             </table>
          </div>
          <div class="clearfix"></div>
          <div class="bg_brown clearfix">
             <a rel="nofollow" class="conect_out " title="In vé dò" href="https://xoso.me/in-ve-do.html">In
             vé dò</a>
          </div>
       </div>
    </div>
    <div class="box">
       <h2 class="tit-mien bold"><a class="title-a" href="/thong-ke-lo-gan-xo-so-mien-bac-xsmb.html" title="Thống kê lô gan.Miền Bắc">Thống kê lô gan Miền Bắc</a> ngày 28/7/2022</h2>
       <div class="scoll  box-logan">
          <table class="mag0 bold">
             <tbody>
                <tr>
                   <th>Bộ số</th>
                   <th>Ngày ra gần đây</th>
                   <th>Số ngày gan</th>
                   <th>Gan cực đại</th>
                </tr>
                <tr>
                   <td>63</td>
                   <td><a class="sub-title" href="/xsmb-6-7-2022-ket-qua-xo-so-mien-bac-ngay-6-7-2022.html" title="KQXS Miền Bắc ngày 06-07-2022">06-07-2022</a></td>
                   <td class="s18 clred">21</td>
                   <td class="s18 clred">30</td>
                </tr>
                <tr>
                   <td>08</td>
                   <td><a class="sub-title" href="/xsmb-8-7-2022-ket-qua-xo-so-mien-bac-ngay-8-7-2022.html" title="KQXS Miền Bắc ngày 08-07-2022">08-07-2022</a></td>
                   <td class="s18 clred">19</td>
                   <td class="s18 clred">34</td>
                </tr>
                <tr>
                   <td>09</td>
                   <td><a class="sub-title" href="/xsmb-13-7-2022-ket-qua-xo-so-mien-bac-ngay-13-7-2022.html" title="KQXS Miền Bắc ngày 13-07-2022">13-07-2022</a></td>
                   <td class="s18 clred">14</td>
                   <td class="s18 clred">26</td>
                </tr>
                <tr>
                   <td>43</td>
                   <td><a class="sub-title" href="/xsmb-14-7-2022-ket-qua-xo-so-mien-bac-ngay-14-7-2022.html" title="KQXS Miền Bắc ngày 14-07-2022">14-07-2022</a></td>
                   <td class="s18 clred">13</td>
                   <td class="s18 clred">30</td>
                </tr>
                <tr>
                   <td>25</td>
                   <td><a class="sub-title" href="/xsmb-15-7-2022-ket-qua-xo-so-mien-bac-ngay-15-7-2022.html" title="KQXS Miền Bắc ngày 15-07-2022">15-07-2022</a></td>
                   <td class="s18 clred">12</td>
                   <td class="s18 clred">28</td>
                </tr>
                <tr>
                   <td>21</td>
                   <td><a class="sub-title" href="/xsmb-17-7-2022-ket-qua-xo-so-mien-bac-ngay-17-7-2022.html" title="KQXS Miền Bắc ngày 17-07-2022">17-07-2022</a></td>
                   <td class="s18 clred">10</td>
                   <td class="s18 clred">28</td>
                </tr>
                <tr>
                   <td>34</td>
                   <td><a class="sub-title" href="/xsmb-17-7-2022-ket-qua-xo-so-mien-bac-ngay-17-7-2022.html" title="KQXS Miền Bắc ngày 17-07-2022">17-07-2022</a></td>
                   <td class="s18 clred">10</td>
                   <td class="s18 clred">30</td>
                </tr>
                <tr>
                   <td>68</td>
                   <td><a class="sub-title" href="/xsmb-17-7-2022-ket-qua-xo-so-mien-bac-ngay-17-7-2022.html" title="KQXS Miền Bắc ngày 17-07-2022">17-07-2022</a></td>
                   <td class="s18 clred">10</td>
                   <td class="s18 clred">27</td>
                </tr>
                <tr>
                   <td>75</td>
                   <td><a class="sub-title" href="/xsmb-17-7-2022-ket-qua-xo-so-mien-bac-ngay-17-7-2022.html" title="KQXS Miền Bắc ngày 17-07-2022">17-07-2022</a></td>
                   <td class="s18 clred">10</td>
                   <td class="s18 clred">26</td>
                </tr>
                <tr>
                   <td>78</td>
                   <td><a class="sub-title" href="/xsmb-17-7-2022-ket-qua-xo-so-mien-bac-ngay-17-7-2022.html" title="KQXS Miền Bắc ngày 17-07-2022">17-07-2022</a></td>
                   <td class="s18 clred">10</td>
                   <td class="s18 clred">33</td>
                </tr>
             </tbody>
          </table>
       </div>
       <div>
          <a class="btn-see-more magb10 txt-center" id="result-see-more" title="Thống kê lô gan" href="/thong-ke-lo-gan-xo-so-mien-bac-xsmb.html">Xem thêm..</a>
       </div>
       <div class="tit-mien bold">Thống kê cặp lô gan Miền Bắc ngày 28/7/2022</div>
       <div class="scoll">
          <table class="mag0 bold">
             <tbody>
                <tr>
                   <th>Cặp lo gan</th>
                   <th>Ngày ra gần đây</th>
                   <th>Số ngày gan</th>
                   <th>Gan cực đại</th>
                </tr>
                <tr>
                   <td>34 - 43</td>
                   <td><a class="sub-title" href="/xsmb-17-7-2022-ket-qua-xo-so-mien-bac-ngay-17-7-2022.html" title="KQXS Miền Bắc ngày 17-07-2022">17-07-2022</a></td>
                   <td class="s18 clred">10</td>
                   <td class="s18 clred">15</td>
                </tr>
                <tr>
                   <td>29 - 92</td>
                   <td><a class="sub-title" href="/xsmb-20-7-2022-ket-qua-xo-so-mien-bac-ngay-20-7-2022.html" title="KQXS Miền Bắc ngày 20-07-2022">20-07-2022</a></td>
                   <td class="s18 clred">7</td>
                   <td class="s18 clred">13</td>
                </tr>
                <tr>
                   <td>07 - 70</td>
                   <td><a class="sub-title" href="/xsmb-23-7-2022-ket-qua-xo-so-mien-bac-ngay-23-7-2022.html" title="KQXS Miền Bắc ngày 23-07-2022">23-07-2022</a></td>
                   <td class="s18 clred">4</td>
                   <td class="s18 clred">14</td>
                </tr>
                <tr>
                   <td>45 - 54</td>
                   <td><a class="sub-title" href="/xsmb-23-7-2022-ket-qua-xo-so-mien-bac-ngay-23-7-2022.html" title="KQXS Miền Bắc ngày 23-07-2022">23-07-2022</a></td>
                   <td class="s18 clred">4</td>
                   <td class="s18 clred">11</td>
                </tr>
                <tr>
                   <td>08 - 80</td>
                   <td><a class="sub-title" href="/xsmb-24-7-2022-ket-qua-xo-so-mien-bac-ngay-24-7-2022.html" title="KQXS Miền Bắc ngày 24-07-2022">24-07-2022</a></td>
                   <td class="s18 clred">3</td>
                   <td class="s18 clred">15</td>
                </tr>
                <tr>
                   <td>23 - 32</td>
                   <td><a class="sub-title" href="/xsmb-24-7-2022-ket-qua-xo-so-mien-bac-ngay-24-7-2022.html" title="KQXS Miền Bắc ngày 24-07-2022">24-07-2022</a></td>
                   <td class="s18 clred">3</td>
                   <td class="s18 clred">17</td>
                </tr>
                <tr>
                   <td>27 - 72</td>
                   <td><a class="sub-title" href="/xsmb-24-7-2022-ket-qua-xo-so-mien-bac-ngay-24-7-2022.html" title="KQXS Miền Bắc ngày 24-07-2022">24-07-2022</a></td>
                   <td class="s18 clred">3</td>
                   <td class="s18 clred">14</td>
                </tr>
                <tr>
                   <td>49 - 94</td>
                   <td><a class="sub-title" href="/xsmb-24-7-2022-ket-qua-xo-so-mien-bac-ngay-24-7-2022.html" title="KQXS Miền Bắc ngày 24-07-2022">24-07-2022</a></td>
                   <td class="s18 clred">3</td>
                   <td class="s18 clred">13</td>
                </tr>
                <tr>
                   <td>57 - 75</td>
                   <td><a class="sub-title" href="/xsmb-24-7-2022-ket-qua-xo-so-mien-bac-ngay-24-7-2022.html" title="KQXS Miền Bắc ngày 24-07-2022">24-07-2022</a></td>
                   <td class="s18 clred">3</td>
                   <td class="s18 clred">13</td>
                </tr>
                <tr>
                   <td>59 - 95</td>
                   <td><a class="sub-title" href="/xsmb-24-7-2022-ket-qua-xo-so-mien-bac-ngay-24-7-2022.html" title="KQXS Miền Bắc ngày 24-07-2022">24-07-2022</a></td>
                   <td class="s18 clred">3</td>
                   <td class="s18 clred">17</td>
                </tr>
             </tbody>
          </table>
       </div>
       <div class="box tk_loto_cl" id="tk_loto1">
          <h2 class="tit-mien bold">
             Thống kê lô tô Miền Bắc ngày 28/7/2022 
          </h2>
          <ul class="list-loto-mb">
             <li>
                <h3 class="bg_ef bold pad10-5 txt-center">Bộ số ra nhiều nhất trong 10 lần quay tính đến ngày 28/7/2022</h3>
                <table class="strip-side">
                   <tbody>
                      <tr>
                         <td class=" bold clred s18 mag10">
                            55 
                         </td>
                         <td class="bold">
                            7 lần
                         </td>
                         <td><span class="s18 clgreen">▲</span></td>
                         <td class="txt-left"> Tăng 1 lần so với 20 lần trước</td>
                      </tr>
                      <tr>
                         <td class=" bold clred s18 mag10">
                            85 
                         </td>
                         <td class="bold">
                            6 lần
                         </td>
                         <td><span class="s18 clgreen">▲</span></td>
                         <td class="txt-left"> Tăng 5 lần so với 20 lần trước</td>
                      </tr>
                      <tr>
                         <td class=" bold clred s18 mag10">
                            93 
                         </td>
                         <td class="bold">
                            6 lần
                         </td>
                         <td><span class="s18 clgreen">▲</span></td>
                         <td class="txt-left"> Tăng 2 lần so với 20 lần trước</td>
                      </tr>
                      <tr>
                         <td class=" bold clred s18 mag10">
                            15 
                         </td>
                         <td class="bold">
                            5 lần
                         </td>
                         <td><span class="s18 clgreen">▲</span></td>
                         <td class="txt-left"> Tăng 2 lần so với 20 lần trước</td>
                      </tr>
                      <tr>
                         <td class=" bold clred s18 mag10">
                            31 
                         </td>
                         <td class="bold">
                            5 lần
                         </td>
                         <td><span class="s18 clgreen">▲</span></td>
                         <td class="txt-left"> Tăng 2 lần so với 20 lần trước</td>
                      </tr>
                      <tr>
                         <td class=" bold clred s18 mag10">
                            35 
                         </td>
                         <td class="bold">
                            5 lần
                         </td>
                         <td><span class="s18 clgreen">▲</span></td>
                         <td class="txt-left"> Tăng 1 lần so với 20 lần trước</td>
                      </tr>
                      <tr>
                         <td class=" bold clred s18 mag10">
                            50 
                         </td>
                         <td class="bold">
                            5 lần
                         </td>
                         <td><span class="s18 clyellow">=</span></td>
                         <td class="txt-left"> Bằng so với lần trước</td>
                      </tr>
                      <tr>
                         <td class=" bold clred s18 mag10">
                            61 
                         </td>
                         <td class="bold">
                            5 lần
                         </td>
                         <td><span class="s18 clgreen">▲</span></td>
                         <td class="txt-left"> Tăng 1 lần so với 20 lần trước</td>
                      </tr>
                   </tbody>
                </table>
             </li>
             <li>
                <h3 class="bg_ef bold pad10-5 txt-center">Bộ số ra nhiều nhất trong 20 lần quay tính đến ngày 28/7/2022</h3>
                <table class="strip-side">
                   <tbody>
                      <tr>
                         <td class=" bold clred s18 mag10">
                            10 
                         </td>
                         <td class="bold">
                            13 lần
                         </td>
                         <td><span class="s18 clgreen">▲</span></td>
                         <td class="txt-left"> Tăng 8 lần so với 20 lần trước</td>
                      </tr>
                      <tr>
                         <td class=" bold clred s18 mag10">
                            55 
                         </td>
                         <td class="bold">
                            13 lần
                         </td>
                         <td><span class="s18 clgreen">▲</span></td>
                         <td class="txt-left"> Tăng 9 lần so với 20 lần trước</td>
                      </tr>
                      <tr>
                         <td class=" bold clred s18 mag10">
                            13 
                         </td>
                         <td class="bold">
                            10 lần
                         </td>
                         <td><span class="s18 clgreen">▲</span></td>
                         <td class="txt-left"> Tăng 4 lần so với 20 lần trước</td>
                      </tr>
                      <tr>
                         <td class=" bold clred s18 mag10">
                            14 
                         </td>
                         <td class="bold">
                            10 lần
                         </td>
                         <td><span class="s18 clgreen">▲</span></td>
                         <td class="txt-left"> Tăng 7 lần so với 20 lần trước</td>
                      </tr>
                      <tr>
                         <td class=" bold clred s18 mag10">
                            40 
                         </td>
                         <td class="bold">
                            10 lần
                         </td>
                         <td><span class="s18 clgreen">▲</span></td>
                         <td class="txt-left"> Tăng 1 lần so với 20 lần trước</td>
                      </tr>
                      <tr>
                         <td class=" bold clred s18 mag10">
                            50 
                         </td>
                         <td class="bold">
                            10 lần
                         </td>
                         <td><span class="s18 clgreen">▲</span></td>
                         <td class="txt-left"> Tăng 3 lần so với 20 lần trước</td>
                      </tr>
                      <tr>
                         <td class=" bold clred s18 mag10">
                            93 
                         </td>
                         <td class="bold">
                            10 lần
                         </td>
                         <td><span class="s18 clgreen">▲</span></td>
                         <td class="txt-left"> Tăng 5 lần so với 20 lần trước</td>
                      </tr>
                      <tr>
                         <td class=" bold clred s18 mag10">
                            19 
                         </td>
                         <td class="bold">
                            9 lần
                         </td>
                         <td><span class="s18 clgreen">▲</span></td>
                         <td class="txt-left"> Tăng 5 lần so với 20 lần trước</td>
                      </tr>
                   </tbody>
                </table>
             </li>
          </ul>
       </div>
    </div>
@endsection