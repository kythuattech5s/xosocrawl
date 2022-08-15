<h2 class="tit-mien clearfix">
    <strong>
        <a class="title-a " href="{{ $lottoItem->lottoCategory->slug }}"
            title="{{ $lottoItem->lottoCategory->short_name }}">{{ $lottoItem->lottoCategory->short_name }}</a>
        »
        <a class="title-a" href="{{ $lottoItem->getSlug() }}"
            title="{{ $lottoItem->short_name }}">{{ $lottoItem->short_name }}</a>
        »
        <a class="title-a " href="{{ $lottoRecord->link($linkPrefix ?? '') }}"
            title="Xổ số {{ $lottoItem->name }} {{ Support::format($lottoRecord->created_at) }}">Xổ số
            {{ $lottoItem->name }} {{ Support::format($lottoRecord->created_at) }}</a>
        {{ Support::getDayOfWeek($lottoRecord->created_at) }}
    </strong>
</h2>
