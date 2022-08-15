<div class="tit-mien clearfix">
    <h2> {{ $lottoCategory->short_name }} - Xổ số {{ $lottoCategory->name }} ngày
        {{ Support::format($lottoRecord->created_at, 'd-m-Y') }}</h2>
    <div>
        <a class="sub-title" href="{{ $lottoCategory->slug }}"
            title="{{ $lottoCategory->short_name }}">{{ $lottoCategory->short_name }}</a>
        »
        <a class="sub-title" href="{{ $lottoCategory->linkDayOfWeek($lottoRecord) }}"
            title="{{ $lottoCategory->short_name }} {{ Support::getDayOfWeek($lottoRecord->created_at) }}">{{ $lottoCategory->short_name }}
            {{ Support::getDayOfWeek($lottoRecord->created_at) }}</a>
        »
        <a class="sub-title" href="{{ $lottoCategory->linkDate($lottoRecord) }}"
            title="{{ $lottoCategory->short_name }} {{ Support::format($lottoRecord->created_at, 'j-n-Y') }}">{{ $lottoCategory->short_name }}
            {{ Support::format($lottoRecord->created_at, 'j-n-Y') }}</a>
    </div>
</div>
