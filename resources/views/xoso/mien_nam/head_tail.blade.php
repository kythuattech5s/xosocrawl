<?php
$transfromCollection = $lottoItemMnCollection->getTransformResults();
$count = $lottoItemMnCollection->countItems();
?>
<div data-id="dd" class="col-firstlast col{{ $count == 3 ? 'three' : 'four' }}city colgiai">
    <table class="firstlast-mn bold">
        <tbody>
            @foreach ($lottoItemMnCollection->headTail()->getHeads() as $key => $provinces)
                @if ($key == -1)
                    <tr class="header">
                        <th class="first">Đầu</th>
                        @foreach ($provinces as $province)
                            <th>{{ $province['item']->name }}</th>
                        @endforeach
                    </tr>
                @endif
            @endforeach
            @foreach ($lottoItemMnCollection->headTail()->getHeads() as $key => $provinces)
                @if ($key != -1)
                    <tr>
                        <td class="clnote bold">{{ $key }}</td>
                        @foreach ($provinces as $province)
                            <td class="v-loto-dau-{{ $key }}">{!! implode(
                                ',',
                                array_map(function ($number) {
                                    return $number->isSpecial() ? '<span class="clred">' . $number->getNumber() . '</span>' : $number->getNumber();
                                }, $province['numbers']),
                            ) !!}
                            </td>
                        @endforeach
                    </tr>
                @endif
            @endforeach

        </tbody>
    </table>
</div>
