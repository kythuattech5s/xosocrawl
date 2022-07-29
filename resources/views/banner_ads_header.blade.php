@php
    $bannerGdnHeader = App\Models\BannerGdn::where('banner_gdn_category_id',1)->act()->ord()->first();
@endphp
@if (isset($bannerGdnHeader))
    <div class="txt-center ads">
        <div class="center ads dspblockinline">
            @if ($bannerGdnHeader->use_code != 1)
                <a class="dspinlineblock banner-link" data-pos="banner_header" href="{{Support::show($bannerGdnHeader,'link')}}" {{$bannerGdnHeader->nofollow == 1 ? 'rel="nofollow"':''}} {{$bannerGdnHeader->is_blank == 1 ? ' target="_blank"':''}} title="{{Support::show($bannerGdnHeader,'name')}}">
                    <img class="dsp-desktop" height="90" src="{%IMGV2.bannerGdnHeader.img.-1%}" width="728" alt="{%AIMGV2.bannerGdnHeader.img.alt%}"/>
                    <img class="dsp-mobile" height="100" src="{%IMGV2.bannerGdnHeader.img_mobile.-1%}" width="320" alt="{%AIMGV2.bannerGdnHeader.img_mobile.alt%}"/>
                </a>
            @else
                {!!$bannerGdnHeader->banner_content!!}
            @endif
        </div>
    </div>
@endif