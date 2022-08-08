<ul class="tab-panel tab-auto">
    @foreach (App\Models\StaticalLotteryNorthern::act()->get() as $item)
        <li class="{{isset($activeId) && $item->id == $activeId ? 'active':''}}">
            <a href="{{$item->slug}}" title="{{$item->short_name}}">{{$item->short_name}}</a>
        </li>
    @endforeach
</ul>