@php
    $bannerGdnHorizontal = App\Models\BannerGdn::where('banner_gdn_category_id',$positionType)->act()->inRandomOrder()->first();
@endphp
@if (isset($bannerGdnHorizontal))
    <div class="txt-center ads">
        <div class="center ads dspblockinline">
            @if ($bannerGdnHorizontal->use_code != 1)
                <a class="dspinlineblock banner-link" data-pos="banner_header" href="{{$bannerGdnHorizontal->buildLink()}}" {!!$bannerGdnHorizontal->nofollow == 1 ? 'rel="nofollow"':''!!} {!!$bannerGdnHorizontal->is_blank == 1 ? ' target="_blank"':''!!} title="{{Support::show($bannerGdnHorizontal,'name')}}">
                    <img class="dsp-desktop" height="90" src="{%IMGV2.bannerGdnHorizontal.img.-1%}" width="728" alt="{%AIMGV2.bannerGdnHorizontal.img.alt%}"/>
                    <img class="dsp-mobile" height="100" src="{%IMGV2.bannerGdnHorizontal.img_mobile.-1%}" width="320" alt="{%AIMGV2.bannerGdnHorizontal.img_mobile.alt%}"/>
                </a>
            @else
                {!!$bannerGdnHorizontal->banner_content!!}
            @endif
        </div>
    </div>
@endif