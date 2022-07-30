@php
    use Lotto\Models\LottoCategory;
@endphp
<div class="col-center">
    @php
        $categories = LottoCategory::act()->get();
        
    @endphp
    @foreach($categories as $category)
    <div class="content-right bullet">
        <div class="title-r">
            @if($category->can_access)
                <a href="{(category.slug)}" title="{(category.name)}">{(category.name)}</a>
            @else
                {(category.name)}
            @endif
        </div>
        <ul>
            @foreach ($category->lottoItems as $item )
            <li>
                <a href="{(item.slug)}" title="Xổ số {(item.name)}"> {(item.name)} </a>
                @if($item->hasResultToday())
                    <img alt="image status" class="" height="10" src="theme/frontend/images/waiting.gif" width="30">
                @endif
            </li>
            @endforeach
        </ul>
    </div>
    @endforeach
  
</div>