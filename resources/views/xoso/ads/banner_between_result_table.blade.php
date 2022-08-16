@php
$bannerGdn = \App\Models\BannerGdn::where('banner_gdn_category_id', \App\Models\BannerGdnCategory::BANNER_BETWEEN_RESULT_TABLE)
    ->act()
    ->inRandomOrder()
    ->limit(1)
    ->first();
@endphp
@if ($bannerGdn->use_code != 1)
    <a class="banner-link" data-pos="banner_square_2" href="{{ $bannerGdn->buildLink() }}" {!! $bannerGdn->nofollow == 1 ? 'rel="nofollow"' : '' !!}
        {!! $bannerGdn->is_blank == 1 ? ' target="_blank"' : '' !!} title="{{ Support::show($bannerGdn, 'name') }}">
        <img src="{%IMGV2.bannerGdn.img.-1%}" alt="{%AIMGV2.bannerGdn.img.alt%}" />
    </a>
@else
    {!! $bannerGdn->banner_content !!}
@endif
