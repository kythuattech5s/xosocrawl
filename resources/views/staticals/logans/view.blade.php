@php
    use ModuleStatical\Helpers\ModuleStaticalHelper;
    use ModuleStatical\TrungNam\ModuleStaticalLoganTrungNam;
@endphp
@extends('index')
@section('breadcrumb')
    {{Breadcrumbs::render('logans', $currentItem)}}
@endsection
@section('main')
    @include('staticals.logan_categories.list_tab_panel',['activeId'=>isset($currentItem->category) ? $currentItem->category->id:0])
    <div class="box tbl-row-hover">
        <h2 class="tit-mien">
            <strong>Thống kê lô tô gan {{Support::show($currentItem,'province_name')}} ngày {{now()->format('d/m/Y')}}</strong>
        </h2>
        <form id="statistic-form" class="form-horizontal" action="{{$currentItem->slug}}" method="post" accept-charset="utf8">
            @csrf
            <div class="form-group field-statisticform-provinceid">
                <label class="control-label" for="statisticform-provinceid">Chọn tỉnh</label>
                <select id="statisticform-provinceid" class="form-control" name="province" onchange="document.querySelector('#statistic-form').submit()">
                    @foreach ($listLogan as $item)
                        <option value="{{Support::show($item,'province_code')}}" {{$currentItem->id == $item->id ? 'selected':''}}>{{Support::show($item,'province_name')}}</option>
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
        <h2 class="tit-mien bold"><a href="{{$currentItem->slug}}" title="thống kê lô gan {{Support::show($currentItem,'province_name')}}" class="title-a">Thống kê lô gan {{Support::show($currentItem,'province_name')}}</a> lâu chưa về nhất tính đến ngày hôm nay</h2>
        <div>
            <table class="mag0">
                <tbody>
                    <tr>
                        <th>Bộ số</th>
                        <th>Ngày ra gần đây</th>
                        <th>Số ngày gan</th>
                        <th>Gan cực đại</th>
                    </tr>
                    @foreach (ModuleStaticalLoganTrungNam::getTopGanByLoganItem($currentItem,$activeNumOfDay) as $item)
                        @php
                            $maxTime = ModuleStaticalHelper::parseStringToTime($item->max_time);
                            $shortCodeDay = Support::createShortCodeDay($maxTime);
                        @endphp
                        <tr>
                            <td><strong>{{$item->duoi}}</strong></td>
                            <td><a class="sub-title" href="{{$currentItem->lottoItem->buildLinkKetQua($maxTime)}}" title="xổ số {{Support::show($currentItem,'province_name')}} ngày {{Support::showDateTime($maxTime,'d-m-Y')}}">{{Support::showDateTime($maxTime,'d-m-Y')}}</a></td>
                            <td class="s18 clred bold">{{$item->gan}}</td>
                            <td class="s18 clred bold">{{$item->gan_maximum}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="box tbl-row-hover clearfix">
        <h2 class="tit-mien bold"><a href="{{$currentItem->slug}}" title="thống kê lô gan {{Support::show($currentItem,'province_name')}}" class="title-a">Cặp lô gan {{Support::show($currentItem,'province_name')}}</a> lâu chưa về nhất tính đến ngày hôm nay</h2>
        <div>
            <table class="mag0">
                <tbody>
                    <tr>
                        <th>Cặp số</th>
                        <th>Ngày ra gần đây</th>
                        <th>Số ngày gan</th>
                        <th>Gan cực đại</th>
                    </tr>
                    @foreach (ModuleStaticalLoganTrungNam::getTopCapLogan($currentItem,$activeNumOfDay) as $key => $item)
                        @php
                            $maxTime = ModuleStaticalHelper::parseStringToTime($item['max_time']);
                            $shortCodeDay = Support::createShortCodeDay($maxTime);
                        @endphp
                        <tr>
                            <td class="s18 bold">{{str_replace('-',' - ',$key)}}</td>
                            <td><a class="sub-title" href="{{$currentItem->lottoItem->buildLinkKetQua($maxTime)}}" title="KQXS {{Support::show($currentItem,'province_name')}} ngày {{Support::showDateTime($maxTime,'d-m-Y')}}">{{Support::showDateTime($maxTime,'d-m-Y')}}</a></td>
                            <td class="s18 clred bold">{{$item['gan']}}</td>
                            <td class="s18 clred bold">17</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="box tbl-row-hover clearfix">
        <h2 class="tit-mien bold"><a href="/thong-ke-lo-gan-xo-so-binh-dinh-xsbdi.html" title="thống kê lô gan Bình Định" class="title-a">Gan cực đại Bình Định</a> các số từ 00-99 từ trước đến nay</h2>
        <div>
            <table class="tbl50">
                <tbody>
                    <tr>
                        <th>Bộ số</th>
                        <th>Gan cực đại</th>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">00</strong></td>
                        <td><span class="s18 clred bold">29</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">01</strong></td>
                        <td><span class="s18 clred bold">24</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">02</strong></td>
                        <td><span class="s18 clred bold">28</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">03</strong></td>
                        <td><span class="s18 clred bold">22</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">04</strong></td>
                        <td><span class="s18 clred bold">24</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">05</strong></td>
                        <td><span class="s18 clred bold">34</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">06</strong></td>
                        <td><span class="s18 clred bold">24</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">07</strong></td>
                        <td><span class="s18 clred bold">27</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">08</strong></td>
                        <td><span class="s18 clred bold">29</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">09</strong></td>
                        <td><span class="s18 clred bold">29</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">10</strong></td>
                        <td><span class="s18 clred bold">35</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">11</strong></td>
                        <td><span class="s18 clred bold">55</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">12</strong></td>
                        <td><span class="s18 clred bold">23</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">13</strong></td>
                        <td><span class="s18 clred bold">30</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">14</strong></td>
                        <td><span class="s18 clred bold">33</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">15</strong></td>
                        <td><span class="s18 clred bold">27</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">16</strong></td>
                        <td><span class="s18 clred bold">30</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">17</strong></td>
                        <td><span class="s18 clred bold">53</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">18</strong></td>
                        <td><span class="s18 clred bold">20</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">19</strong></td>
                        <td><span class="s18 clred bold">26</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">20</strong></td>
                        <td><span class="s18 clred bold">27</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">21</strong></td>
                        <td><span class="s18 clred bold">29</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">22</strong></td>
                        <td><span class="s18 clred bold">41</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">23</strong></td>
                        <td><span class="s18 clred bold">34</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">24</strong></td>
                        <td><span class="s18 clred bold">28</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">25</strong></td>
                        <td><span class="s18 clred bold">24</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">26</strong></td>
                        <td><span class="s18 clred bold">33</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">27</strong></td>
                        <td><span class="s18 clred bold">27</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">28</strong></td>
                        <td><span class="s18 clred bold">36</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">29</strong></td>
                        <td><span class="s18 clred bold">20</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">30</strong></td>
                        <td><span class="s18 clred bold">31</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">31</strong></td>
                        <td><span class="s18 clred bold">23</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">32</strong></td>
                        <td><span class="s18 clred bold">30</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">33</strong></td>
                        <td><span class="s18 clred bold">24</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">34</strong></td>
                        <td><span class="s18 clred bold">31</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">35</strong></td>
                        <td><span class="s18 clred bold">49</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">36</strong></td>
                        <td><span class="s18 clred bold">27</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">37</strong></td>
                        <td><span class="s18 clred bold">25</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">38</strong></td>
                        <td><span class="s18 clred bold">22</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">39</strong></td>
                        <td><span class="s18 clred bold">29</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">40</strong></td>
                        <td><span class="s18 clred bold">26</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">41</strong></td>
                        <td><span class="s18 clred bold">23</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">42</strong></td>
                        <td><span class="s18 clred bold">36</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">43</strong></td>
                        <td><span class="s18 clred bold">32</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">44</strong></td>
                        <td><span class="s18 clred bold">19</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">45</strong></td>
                        <td><span class="s18 clred bold">29</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">46</strong></td>
                        <td><span class="s18 clred bold">33</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">47</strong></td>
                        <td><span class="s18 clred bold">29</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">48</strong></td>
                        <td><span class="s18 clred bold">51</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">49</strong></td>
                        <td><span class="s18 clred bold">19</span> ngày</td>
                    </tr>
                </tbody>
            </table>
            <table class="tbl50">
                <tbody>
                    <tr>
                        <th>Bộ số</th>
                        <th>Gan cực đại</th>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">50</strong></td>
                        <td><span class="s18 clred bold">50</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">51</strong></td>
                        <td><span class="s18 clred bold">33</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">52</strong></td>
                        <td><span class="s18 clred bold">48</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">53</strong></td>
                        <td><span class="s18 clred bold">44</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">54</strong></td>
                        <td><span class="s18 clred bold">29</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">55</strong></td>
                        <td><span class="s18 clred bold">26</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">56</strong></td>
                        <td><span class="s18 clred bold">28</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">57</strong></td>
                        <td><span class="s18 clred bold">27</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">58</strong></td>
                        <td><span class="s18 clred bold">23</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">59</strong></td>
                        <td><span class="s18 clred bold">26</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">60</strong></td>
                        <td><span class="s18 clred bold">24</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">61</strong></td>
                        <td><span class="s18 clred bold">29</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">62</strong></td>
                        <td><span class="s18 clred bold">22</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">63</strong></td>
                        <td><span class="s18 clred bold">27</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">64</strong></td>
                        <td><span class="s18 clred bold">38</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">65</strong></td>
                        <td><span class="s18 clred bold">30</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">66</strong></td>
                        <td><span class="s18 clred bold">29</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">67</strong></td>
                        <td><span class="s18 clred bold">23</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">68</strong></td>
                        <td><span class="s18 clred bold">26</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">69</strong></td>
                        <td><span class="s18 clred bold">26</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">70</strong></td>
                        <td><span class="s18 clred bold">25</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">71</strong></td>
                        <td><span class="s18 clred bold">30</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">72</strong></td>
                        <td><span class="s18 clred bold">30</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">73</strong></td>
                        <td><span class="s18 clred bold">40</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">74</strong></td>
                        <td><span class="s18 clred bold">27</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">75</strong></td>
                        <td><span class="s18 clred bold">30</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">76</strong></td>
                        <td><span class="s18 clred bold">33</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">77</strong></td>
                        <td><span class="s18 clred bold">24</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">78</strong></td>
                        <td><span class="s18 clred bold">25</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">79</strong></td>
                        <td><span class="s18 clred bold">23</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">80</strong></td>
                        <td><span class="s18 clred bold">24</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">81</strong></td>
                        <td><span class="s18 clred bold">28</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">82</strong></td>
                        <td><span class="s18 clred bold">33</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">83</strong></td>
                        <td><span class="s18 clred bold">38</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">84</strong></td>
                        <td><span class="s18 clred bold">39</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">85</strong></td>
                        <td><span class="s18 clred bold">31</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">86</strong></td>
                        <td><span class="s18 clred bold">31</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">87</strong></td>
                        <td><span class="s18 clred bold">30</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">88</strong></td>
                        <td><span class="s18 clred bold">25</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">89</strong></td>
                        <td><span class="s18 clred bold">33</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">90</strong></td>
                        <td><span class="s18 clred bold">34</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">91</strong></td>
                        <td><span class="s18 clred bold">31</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">92</strong></td>
                        <td><span class="s18 clred bold">25</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">93</strong></td>
                        <td><span class="s18 clred bold">53</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">94</strong></td>
                        <td><span class="s18 clred bold">34</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">95</strong></td>
                        <td><span class="s18 clred bold">33</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">96</strong></td>
                        <td><span class="s18 clred bold">34</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">97</strong></td>
                        <td><span class="s18 clred bold">46</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">98</strong></td>
                        <td><span class="s18 clred bold">21</span> ngày</td>
                    </tr>
                    <tr>
                        <td><strong class="s18 bold">99</strong></td>
                        <td><span class="s18 clred bold">31</span> ngày</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="box tbl-row-hover">
        <h2 class="tit-mien bold"><a class="title-a" href="/thong-ke-giai-dac-biet-xo-so-binh-dinh-xsbdi.html" title="Thống kê giải đặc biệt Bình Định">Thống kê giải đặc biệt Bình Định</a> lâu chưa về nhất tính đến ngày hôm nay</h2>
        <div>
            <table class="mag0">
                <tbody>
                    <tr>
                        <th>Bộ số</th>
                        <th>Ngày ra gần đây</th>
                        <th>Số ngày gan</th>
                    </tr>
                    <tr>
                        <td class="s18 bold">30</td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-22-5-2014-ket-qua-xo-so-binh-dinh-ngay-22-5-2014-p23.html" title="KQXS Bình Định ngày 22-05-2014">22-05-2014</a></td>
                        <td class="s18 clred bold">424</td>
                    </tr>
                    <tr>
                        <td class="s18 bold">42</td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-2-4-2015-ket-qua-xo-so-binh-dinh-ngay-2-4-2015-p23.html" title="KQXS Bình Định ngày 02-04-2015">02-04-2015</a></td>
                        <td class="s18 clred bold">379</td>
                    </tr>
                    <tr>
                        <td class="s18 bold">40</td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-17-9-2015-ket-qua-xo-so-binh-dinh-ngay-17-9-2015-p23.html" title="KQXS Bình Định ngày 17-09-2015">17-09-2015</a></td>
                        <td class="s18 clred bold">355</td>
                    </tr>
                    <tr>
                        <td class="s18 bold">92</td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-1-12-2016-ket-qua-xo-so-binh-dinh-ngay-1-12-2016-p23.html" title="KQXS Bình Định ngày 01-12-2016">01-12-2016</a></td>
                        <td class="s18 clred bold">292</td>
                    </tr>
                    <tr>
                        <td class="s18 bold">64</td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-16-2-2017-ket-qua-xo-so-binh-dinh-ngay-16-2-2017-p23.html" title="KQXS Bình Định ngày 16-02-2017">16-02-2017</a></td>
                        <td class="s18 clred bold">281</td>
                    </tr>
                    <tr>
                        <td class="s18 bold">18</td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-10-8-2017-ket-qua-xo-so-binh-dinh-ngay-10-8-2017-p23.html" title="KQXS Bình Định ngày 10-08-2017">10-08-2017</a></td>
                        <td class="s18 clred bold">256</td>
                    </tr>
                    <tr>
                        <td class="s18 bold">68</td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-21-9-2017-ket-qua-xo-so-binh-dinh-ngay-21-9-2017-p23.html" title="KQXS Bình Định ngày 21-09-2017">21-09-2017</a></td>
                        <td class="s18 clred bold">250</td>
                    </tr>
                    <tr>
                        <td class="s18 bold">46</td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-14-12-2017-ket-qua-xo-so-binh-dinh-ngay-14-12-2017-p23.html" title="KQXS Bình Định ngày 14-12-2017">14-12-2017</a></td>
                        <td class="s18 clred bold">238</td>
                    </tr>
                    <tr>
                        <td class="s18 bold">52</td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-28-12-2017-ket-qua-xo-so-binh-dinh-ngay-28-12-2017-p23.html" title="KQXS Bình Định ngày 28-12-2017">28-12-2017</a></td>
                        <td class="s18 clred bold">236</td>
                    </tr>
                    <tr>
                        <td class="s18 bold">13</td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-26-4-2018-ket-qua-xo-so-binh-dinh-ngay-26-4-2018-p23.html" title="KQXS Bình Định ngày 26-04-2018">26-04-2018</a></td>
                        <td class="s18 clred bold">219</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="box tbl-row-hover">
        <h2 class="tit-mien bold">Thống kê đầu giải đặc biệt Bình Định lâu chưa ra</h2>
        <div>
            <table class="mag0">
                <tbody>
                    <tr>
                        <th>Đầu số</th>
                        <th>Ngày ra gần đây</th>
                        <th>Số ngày gan</th>
                    </tr>
                    <tr>
                        <td><strong class="s18">9</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-17-2-2022-ket-qua-xo-so-binh-dinh-ngay-17-2-2022-p23.html" title="KQXS Bình Định ngày 17-02-2022">17-02-2022</a></td>
                        <td class="s18 clred bold">24</td>
                    </tr>
                    <tr>
                        <td><strong class="s18">5</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-3-3-2022-ket-qua-xo-so-binh-dinh-ngay-3-3-2022-p23.html" title="KQXS Bình Định ngày 03-03-2022">03-03-2022</a></td>
                        <td class="s18 clred bold">22</td>
                    </tr>
                    <tr>
                        <td><strong class="s18">4</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-7-4-2022-ket-qua-xo-so-binh-dinh-ngay-7-4-2022-p23.html" title="KQXS Bình Định ngày 07-04-2022">07-04-2022</a></td>
                        <td class="s18 clred bold">17</td>
                    </tr>
                    <tr>
                        <td><strong class="s18">0</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-2-6-2022-ket-qua-xo-so-binh-dinh-ngay-2-6-2022-p23.html" title="KQXS Bình Định ngày 02-06-2022">02-06-2022</a></td>
                        <td class="s18 clred bold">9</td>
                    </tr>
                    <tr>
                        <td><strong class="s18">8</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-16-6-2022-ket-qua-xo-so-binh-dinh-ngay-16-6-2022-p23.html" title="KQXS Bình Định ngày 16-06-2022">16-06-2022</a></td>
                        <td class="s18 clred bold">7</td>
                    </tr>
                    <tr>
                        <td><strong class="s18">1</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-23-6-2022-ket-qua-xo-so-binh-dinh-ngay-23-6-2022-p23.html" title="KQXS Bình Định ngày 23-06-2022">23-06-2022</a></td>
                        <td class="s18 clred bold">6</td>
                    </tr>
                    <tr>
                        <td><strong class="s18">6</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-7-7-2022-ket-qua-xo-so-binh-dinh-ngay-7-7-2022-p23.html" title="KQXS Bình Định ngày 07-07-2022">07-07-2022</a></td>
                        <td class="s18 clred bold">4</td>
                    </tr>
                    <tr>
                        <td><strong class="s18">2</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-21-7-2022-ket-qua-xo-so-binh-dinh-ngay-21-7-2022-p23.html" title="KQXS Bình Định ngày 21-07-2022">21-07-2022</a></td>
                        <td class="s18 clred bold">2</td>
                    </tr>
                    <tr>
                        <td><strong class="s18">7</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-28-7-2022-ket-qua-xo-so-binh-dinh-ngay-28-7-2022-p23.html" title="KQXS Bình Định ngày 28-07-2022">28-07-2022</a></td>
                        <td class="s18 clred bold">1</td>
                    </tr>
                    <tr>
                        <td><strong class="s18">3</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-4-8-2022-ket-qua-xo-so-binh-dinh-ngay-4-8-2022-p23.html" title="KQXS Bình Định ngày 04-08-2022">04-08-2022</a></td>
                        <td class="s18 clred bold">0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="box tbl-row-hover">
        <h2 class="tit-mien bold">Thống kê đuôi giải đặc biệt Bình Định lâu chưa về</h2>
        <div class="scoll">
            <table class="mag0">
                <tbody>
                    <tr>
                        <th>Đuôi số</th>
                        <th>Ngày ra gần đây</th>
                        <th>Số ngày gan</th>
                    </tr>
                    <tr>
                        <td><strong class="s18">6</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-17-3-2022-ket-qua-xo-so-binh-dinh-ngay-17-3-2022-p23.html" title="KQXS Bình Định ngày 17-03-2022">17-03-2022</a></td>
                        <td class="s18 clred bold">20</td>
                    </tr>
                    <tr>
                        <td><strong class="s18">3</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-12-5-2022-ket-qua-xo-so-binh-dinh-ngay-12-5-2022-p23.html" title="KQXS Bình Định ngày 12-05-2022">12-05-2022</a></td>
                        <td class="s18 clred bold">12</td>
                    </tr>
                    <tr>
                        <td><strong class="s18">2</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-19-5-2022-ket-qua-xo-so-binh-dinh-ngay-19-5-2022-p23.html" title="KQXS Bình Định ngày 19-05-2022">19-05-2022</a></td>
                        <td class="s18 clred bold">11</td>
                    </tr>
                    <tr>
                        <td><strong class="s18">5</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-2-6-2022-ket-qua-xo-so-binh-dinh-ngay-2-6-2022-p23.html" title="KQXS Bình Định ngày 02-06-2022">02-06-2022</a></td>
                        <td class="s18 clred bold">9</td>
                    </tr>
                    <tr>
                        <td><strong class="s18">8</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-16-6-2022-ket-qua-xo-so-binh-dinh-ngay-16-6-2022-p23.html" title="KQXS Bình Định ngày 16-06-2022">16-06-2022</a></td>
                        <td class="s18 clred bold">7</td>
                    </tr>
                    <tr>
                        <td><strong class="s18">9</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-23-6-2022-ket-qua-xo-so-binh-dinh-ngay-23-6-2022-p23.html" title="KQXS Bình Định ngày 23-06-2022">23-06-2022</a></td>
                        <td class="s18 clred bold">6</td>
                    </tr>
                    <tr>
                        <td><strong class="s18">0</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-14-7-2022-ket-qua-xo-so-binh-dinh-ngay-14-7-2022-p23.html" title="KQXS Bình Định ngày 14-07-2022">14-07-2022</a></td>
                        <td class="s18 clred bold">3</td>
                    </tr>
                    <tr>
                        <td><strong class="s18">4</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-21-7-2022-ket-qua-xo-so-binh-dinh-ngay-21-7-2022-p23.html" title="KQXS Bình Định ngày 21-07-2022">21-07-2022</a></td>
                        <td class="s18 clred bold">2</td>
                    </tr>
                    <tr>
                        <td><strong class="s18">7</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-28-7-2022-ket-qua-xo-so-binh-dinh-ngay-28-7-2022-p23.html" title="KQXS Bình Định ngày 28-07-2022">28-07-2022</a></td>
                        <td class="s18 clred bold">1</td>
                    </tr>
                    <tr>
                        <td><strong class="s18">1</strong></td>
                        <td><a class="sub-title" href="https://xoso.me/mien-trung/xsbdi-4-8-2022-ket-qua-xo-so-binh-dinh-ngay-4-8-2022-p23.html" title="KQXS Bình Định ngày 04-08-2022">04-08-2022</a></td>
                        <td class="s18 clred bold">0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="box tbl-row-hover">
        <h3 class="tit-mien"><strong>Thảo luận</strong></h3>
        <div id="comment" class="fb-comments  fb_iframe_widget fb_iframe_widget_fluid_desktop" data-href="https://xoso.me/thong-ke-lo-gan-xo-so-mien-bac-xsmb.html" data-lazy="true" data-numposts="5" data-colorscheme="light" data-width="100%" data-order-by="reverse_time" fb-xfbml-state="parsed" fb-iframe-plugin-query="app_id=224529274568575&amp;color_scheme=light&amp;container_width=565&amp;height=100&amp;href=https%3A%2F%2Fxoso.me%2Fthong-ke-lo-gan-xo-so-mien-bac-xsmb.html&amp;lazy=true&amp;locale=vi_VN&amp;numposts=5&amp;order_by=reverse_time&amp;sdk=joey&amp;version=v7.0&amp;width=" style="width: 100%;"><span style="vertical-align: top; width: 100%; height: 1px; overflow: hidden;"><iframe name="f2b6062c8168f48" width="1000px" height="100px" data-testid="fb:comments Facebook Social Plugin" title="fb:comments Facebook Social Plugin" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" allow="encrypted-media" loading="lazy" src="https://www.facebook.com/v7.0/plugins/comments.php?app_id=224529274568575&amp;channel=https%3A%2F%2Fstaticxx.facebook.com%2Fx%2Fconnect%2Fxd_arbiter%2F%3Fversion%3D46%23cb%3Df3369bc9ebe9ec%26domain%3Dxoso.me%26is_canvas%3Dfalse%26origin%3Dhttps%253A%252F%252Fxoso.me%252Ff3c029e4a20c844%26relation%3Dparent.parent&amp;color_scheme=light&amp;container_width=565&amp;height=100&amp;href=https%3A%2F%2Fxoso.me%2Fthong-ke-lo-gan-xo-so-mien-bac-xsmb.html&amp;lazy=true&amp;locale=vi_VN&amp;numposts=5&amp;order_by=reverse_time&amp;sdk=joey&amp;version=v7.0&amp;width=" style="border: none; width: 100%;"></iframe></span></div>
        <script></script>
    </div>
    <div class="box pad10-5">
        <ul class="list-dot-red">
            <li><img style="width:6px;height:6px" src="css/images/bullet-red.png" alt="icon ve so"><a href="thong-ke-tan-suat-lo-to-xo-so-mien-bac-xsmb" title="Thống kê tần suất miền bắc">Thống kê tần suất miền bắc</a></li>
        </ul>
    </div>
    <div class="box box-html">
        {!!Support::show($currentItem,'content')!!}
    </div>
@endsection