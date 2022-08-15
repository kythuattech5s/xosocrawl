@php
use Lotto\Models\LottoCategory;
@endphp
<div class="col-center">
    @php
        $categories = LottoCategory::act()->get();
        
    @endphp
    @foreach ($categories as $category)
        <div class="content-right bullet">
            <div class="title-r">
                @if ($category->can_access)
                    <a href="{(category.slug)}" title="{(category.name)}">{(category.name)}</a>
                @else
                    {(category.name)}
                @endif
            </div>
            <ul>
                @foreach ($category->lottoItems as $item)
                    @if ($item->hasResultToday())
                        <li>
                            <a href="{{ $item->getSlug() }}" title="Xổ số {(item.name)}"> {(item.name)} </a>
                            {!! $item->getImageStatus() !!}
                        </li>
                    @endif
                @endforeach
                @foreach ($category->lottoItems as $item)
                    @if (!$item->hasResultToday())
                        <li>
                            <a href="{{ $item->getSlug() }}" title="Xổ số {(item.name)}"> {(item.name)} </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endforeach

</div>
