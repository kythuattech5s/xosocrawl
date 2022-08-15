<div class="link-du-doan">
    @foreach (\App\Models\GuessLinkAds::act()->get() as $item)
        <span><img src="{{asset('theme/frontend/images/hot2.gif')}}" width="22" height="11" alt="hot"></span>
        <a class="text-link-ads bold clnote" href="{{$item->buildLink()}}" title="{{Support::show($item,'name')}}" {!!$item->nofollow == 1 ? 'rel="nofollow"':''!!} {!!$item->is_blank == 1 ? ' target="_blank"':''!!}>{{Support::show($item,'name')}}</a>
    @endforeach
 </div>