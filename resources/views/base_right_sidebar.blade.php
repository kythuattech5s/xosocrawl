<div class="col-right">
    <div class="content-right bullet">
        <div class="title-r">
            <strong> Kết quả xổ số hôm qua </strong>
        </div>
        <div>
            <ul class="stastic-lotery two-column">
                <li class="nobor">
                    <a href="https://xoso.me/xsmn-hom-qua-ket-qua-xo-so-mien-nam-hom-qua.html" title="XSMN hôm qua"> XSMN hôm qua </a>
                </li>
                <li>
                    <a href="https://xoso.me/xsmb-hom-qua-ket-qua-xo-so-mien-bac-hom-qua.html" title="XSMB hôm qua"> XSMB hôm qua </a>
                </li>
                <li>
                    <a href="https://xoso.me/xsmt-hom-qua-ket-qua-xo-so-mien-trung-hom-qua.html" title="XSMT hôm qua"> XSMT hôm qua </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="content-right bullet">
        <div class="title-r">
            <strong> Dự đoán các tỉnh hôm nay </strong>
        </div>
        <div>
            <ul class="stastic-lotery two-column">
                <li class="nobor">
                    <a href="https://xoso.me/du-doan-xsdn.html" title="Dự đoán Đồng Nai"> Dự đoán Đồng Nai </a>
                </li>
                <li class="nobor">
                    <a href="https://xoso.me/du-doan-xsct.html" title="Dự đoán Cần Thơ"> Dự đoán Cần Thơ </a>
                </li>
                <li class="nobor">
                    <a href="https://xoso.me/du-doan-xsst.html" title="Dự đoán Sóc Trăng"> Dự đoán Sóc Trăng
                    </a>
                </li>
                <li class="nobor">
                    <a href="https://xoso.me/du-doan-xsdng.html" title="Dự đoán Đà Nẵng"> Dự đoán Đà Nẵng </a>
                </li>
                <li class="nobor">
                    <a href="https://xoso.me/du-doan-xskh.html" title="Dự đoán Khánh Hòa"> Dự đoán Khánh Hòa
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="content-right">
        <div class="title-r">
            <a href="du-doan-ket-qua-xo-so-kqxs-c229" title="Dự đoán xổ số"> Dự đoán xổ số
            </a>
        </div>
        @php
            $listPredictLotteryResultCategory = App\Models\PredictLotteryResultCategory::get();
        @endphp
        <ul class="list-news">
            @foreach ($listPredictLotteryResultCategory as $itemPredictLotteryResultCategory)
                @php
                    $itemPredictLotteryResult = $itemPredictLotteryResultCategory->predictLotteryResult()->act()->orderBy('id','desc')->first();
                @endphp
                @if (isset($itemPredictLotteryResult))
                    <li class="clearfix">
                        <a class="fl" href="{{Support::show($itemPredictLotteryResult,'slug')}}" title="{{Support::show($itemPredictLotteryResult,'name')}}">
                            <img alt="{{Support::show($itemPredictLotteryResult,'name')}}" class="mag-r5 fl" src="{%IMGV2.itemPredictLotteryResult.img.-1%}" height="33" width="60" />
                        </a>
                        <a href="{{Support::show($itemPredictLotteryResult,'slug')}}" title="{{Support::show($itemPredictLotteryResult,'name')}}">{{Support::show($itemPredictLotteryResult,'name')}}</a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    @php
        $listDreamNumber = App\Models\DreamNumberDecoding::inRandomOrder()
                                                        ->limit(4)
                                                        ->get();
    @endphp
    @if (count($listDreamNumber) > 0)
        <div class="content-right">
            <div class="title-r">
                <a href="so-mo-lo-de-mien-bac-so-mo-giai-mong" title="Sổ mơ"> Sổ mơ </a>
            </div>
            <ul class="list-news">
                @if (count($listDreamNumber) > 0)
                    @foreach ($listDreamNumber as $itemDreamNumber)
                        <li class="clearfix">
                            <a class="fl" href="{{Support::show($itemDreamNumber,'slug')}}" title="{{Support::show($itemDreamNumber,'name')}}">
                                <img src="{%IMGV2.itemDreamNumber.img.-1%}" title="{{Support::show($itemDreamNumber,'name')}}" alt="{{Support::show($itemDreamNumber,'name')}}" height="33" width="60" class="mag-r5 fl"/>
                            </a>
                            <a href="{{Support::show($itemDreamNumber,'slug')}}" title="{{Support::show($itemDreamNumber,'name')}}">
                                {{Support::show($itemDreamNumber,'name')}}
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    @endif
    @php
        $listAdvertisingLink = App\Models\AdvertisingLink::act()->ord()->get();
    @endphp
    @if (count($listAdvertisingLink) > 0)
        <div class="content-right link-hay">
            <div class="title-r"> Liên hết hay </div>
            <ul>
                @foreach ($listAdvertisingLink as $itemAdvertisingLink)
                    <li>
                        <div class="img-left">
                            <img class="mag-r5 fl" src="{%IMGV2.itemAdvertisingLink.img.-1%}" alt="{%AIMGV2.itemAdvertisingLink.img.alt%}" style="width:60px;height:33px" />
                        </div>
                        <div class="magl">{!!Support::show($itemAdvertisingLink,'content')!!}</div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @php
        $bannerGdnBottomRightSidebar = App\Models\BannerGdn::where('banner_gdn_category_id',2)->act()->ord()->first();
    @endphp
    @if (isset($bannerGdnBottomRightSidebar))
        <div class="txt-center ads">
            <div class="center ads">
                @if ($bannerGdnBottomRightSidebar->use_code != 1)
                    <a class="banner-link" data-pos="banner_square_2" href="{{Support::show($bannerGdnBottomRightSidebar,'link')}}" {{$bannerGdnBottomRightSidebar->nofollow == 1 ? 'rel="nofollow"':''}} {{$bannerGdnBottomRightSidebar->is_blank == 1 ? ' target="_blank"':''}} title="{{Support::show($bannerGdnBottomRightSidebar,'name')}}">
                        <img src="{%IMGV2.bannerGdnBottomRightSidebar.img.-1%}" alt="{%AIMGV2.bannerGdnBottomRightSidebar.img.alt%}"/>
                    </a>
                @else
                    {!!$bannerGdnBottomRightSidebar->banner_content!!}
                @endif
            </div>
        </div>
    @endif
</div>