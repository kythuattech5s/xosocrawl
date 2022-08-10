<ul class="tab-panel tab-auto">
    @foreach (App\Models\LoganCategory::act()->get() as $item)
        <li class="{{isset($activeId) && $item->id == $activeId ? 'active':''}}">
            <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'short_name')}}">{{Support::show($item,'short_name')}}</a>
        </li>
    @endforeach
</ul>