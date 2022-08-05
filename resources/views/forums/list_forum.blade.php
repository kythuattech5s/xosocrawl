<ul class="tab-panel tab-auto">
    @foreach (App\Models\Forum::act()->orderBy('ord','asc')->get() as $item)
        <li class="{{isset($activeForumId) && $activeForumId == $item->id ? 'active':''}}">
            <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'short_name')}}">{{Support::show($item,'short_name')}}</a>
        </li>
    @endforeach
</ul>