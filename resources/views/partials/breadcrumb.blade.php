@if (count($breadcrumbs) > 0)
    <div class="breadcrumb">
        <ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
            @foreach ($breadcrumbs as $key => $breadcrumb)
                <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="{{$breadcrumb->url}}" title="{{ $breadcrumb->title }}">
                        <span itemprop="name">{{$breadcrumb->title}}</span>
                        <meta itemprop="position" content="1">
                    </a>
                </li>
                @if ($key < count($breadcrumbs) - 1)
                    <li> »</li>
                @endif
            @endforeach
        </ol>
    </div>
@endif