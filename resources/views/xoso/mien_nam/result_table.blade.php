<table class="colthreecity colgiai extendable">
    <tbody>
        @foreach ($lottoItemMnCollection->getTransformResults() as $idx => $items)
            @if ($idx == -1)
                <tr class="gr-yellow">
                    <th class="first"></th>
                    @foreach ($items as $item)
                        <th data-pid="4"><a href="{{ $item['item']->getSlug() }}" title="Xổ số {{ $item['item']->name }}"
                                class="underline bold">{{ $item['item']->name }}</a></th>
                    @endforeach
                </tr>
            @else
                <tr class="g{{ $idx == 0 ? 'db' : $idx }}">
                    <td>{{ $idx == 0 ? 'ĐB' : 'G' . $idx }}</td>
                    @foreach ($items as $item)
                        <td>
                            @foreach ($item['numbers'] as $number)
                                <div class="v-g{{ $idx == 0 ? 'db' : $idx }} ">{{ $number->number }}</div>
                            @endforeach
                        </td>
                    @endforeach
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
