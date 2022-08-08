<div id="menu-mobile-backdrop" onclick="showDrawerMenu()">
</div>
<header>
    <div class="main">
        @if (isset($currentItem) && is_object($currentItem))
            @if (isset($currentItem->name) && $currentItem->name != '')
                <h1 class="taskbar">{{Support::show($currentItem,'name')}}</h1>
            @else
                @if (isset($currentItem->seo_title) && $currentItem->seo_title != '')
                    <h1 class="taskbar">{{Support::show($currentItem,'seo_title')}}</h1>
                @endif
            @endif
        @else
            <h1 class="taskbar">KQXS - XS - Xổ Số Kiến Thiết 3 miền hôm nay - XS3M</h1>
        @endif
        <div class="top-info clearfix pad5" id="top-info">
            <button aria-label="navbar" class="navbar-toggle collapsed fl" onclick="showDrawerMenu()" type="button">
                <span class="icon-bar">
                </span>
                <span class="icon-bar">
                </span>
                <span class="icon-bar">
                </span>
            </button>
            <div class="logo">
                <a class="txtlogo" href="{{url('/')}}" title="{[seo_title]}">{[site_name]}</a>
            </div>
            <a class="download-link bold dsp-mobile fr" href="{[app_android_download_link]}">
                <span> Tải app </span>
            </a>
        </div>
    </div>
    @php
        $menus = App\Models\Menu::act()->ord()->get();
    @endphp
    <nav id="nav">
        <div class="nav-mobi">
            <ul class="nav-mobile clearfix" id="nav-hozital-mobile">
                @foreach ($menus->where('parent',0)->where('menu_category_id',2) as $itemMenuMobile)
                    <li class="fl clearfix ">
                        <a href="{{Support::show($itemMenuMobile,'link')}}" title="{{Support::show($itemMenuMobile,'name')}}">{{Support::show($itemMenuMobile,'name')}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="nav-pc" id="nav-horizontal">
            <ul class="main nav-horizontal clearfix" id="nav-horizontal-list">
                @foreach ($menus->where('parent',0)->where('menu_category_id',1) as $itemMenuPcLv1)
                    <li class="fl clearfix">
                        <a class="fl" href="{{Support::show($itemMenuPcLv1,'link')}}" title="{{Support::show($itemMenuPcLv1,'name')}}">{{Support::show($itemMenuPcLv1,'name')}}</a>
                        <span class="in-block ic arr-d fr" onclick="expand('_a_menu_{{Support::show($itemMenuPcLv1,'id')}}');this.classList.toggle('active');">
                        </span>
                        @php
                            $listMenuPcLv2 = $menus->where('parent',$itemMenuPcLv1->id)->where('menu_category_id',1)
                        @endphp
                        @if (count($listMenuPcLv2) > 0)
                            <ul class="menu-c2" id="_a_menu_{{Support::show($itemMenuPcLv1,'id')}}">
                                @foreach ($listMenuPcLv2 as $itemMenuPcLv2)
                                    <li>
                                        <a href="{{Support::show($itemMenuPcLv2,'link')}}" title="{{Support::show($itemMenuPcLv2,'name')}}">
                                            <strong>{{Support::show($itemMenuPcLv2,'name')}}</strong>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
</header>