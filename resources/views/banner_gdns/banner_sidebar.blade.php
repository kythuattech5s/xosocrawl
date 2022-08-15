@php
    $bannerGdnSidebar = App\Models\BannerGdn::where('banner_gdn_category_id',$positionType)->act()->inRandomOrder()->first();
@endphp
@if (isset($bannerGdnSidebar))
    <div class="txt-center ads">
        <div class="center ads">
            @if ($bannerGdnSidebar->use_code != 1)
                <a class="banner-link" data-pos="banner_square_2" href="{{$bannerGdnSidebar->buildLink()}}" {!!$bannerGdnSidebar->nofollow == 1 ? 'rel="nofollow"':''!!} {!!$bannerGdnSidebar->is_blank == 1 ? ' target="_blank"':''!!} title="{{Support::show($bannerGdnSidebar,'name')}}">
                    <img src="{%IMGV2.bannerGdnSidebar.img.-1%}" alt="{%AIMGV2.bannerGdnSidebar.img.alt%}"/>
                </a>
            @else
                {!!$bannerGdnSidebar->banner_content!!}
            @endif
        </div>
    </div>
@endif