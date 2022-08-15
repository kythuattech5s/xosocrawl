<li class="active"><a href="{{ $lottoCategory->slug }}">{{ $lottoCategory->name }}</a></li>
@for ($i = 2; $i < 9; $i++)
    <li><a href="{{ $lottoCategory->linkDayOfWeek($lottoRecord, $i) }}"
            title="{{ $lottoCategory->short_name }} {{ Support::getLottoDayOfWeek(null, $i) }}">{{ Support::getLottoDayOfWeek(null, $i) }}</a>
    </li>
@endfor
