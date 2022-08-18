<?php
$transfromCollection = $lottoItemMnCollection->getTransformResults();
$count = $lottoItemMnCollection->countItems();
?>
<div data-id="kq" class="{{ $count == 3 ? 'three' : 'four' }}-city" data-region="3">
    <table class="col{{ $count == 3 ? 'three' : 'four' }}city colgiai extendable">
        <tbody>
            @foreach ($transfromCollection as $idx => $items)
                @if ($idx == -1)
                    <tr class="gr-yellow">
                        <th class="first"></th>
                        @foreach ($items as $item)
                            <th data-pid="4"><a href="{{ $item['item']->getSlug() }}"
                                    title="Xổ số {{ $item['item']->name }}"
                                    class="underline bold">{{ $item['item']->name }}</a></th>
                        @endforeach
                    </tr>
                @else
                    <tr class="g{{ $idx == 0 ? 'db' : $idx }}">
                        <td>{{ $idx == 0 ? 'ĐB' : 'G' . $idx }}</td>
                        @foreach ($items as $item)
                            <td>
                                @foreach ($item['numbers'] as $number)
                                    <div class="v-g{{ $idx == 0 ? 'db' : $idx }} v-giai number ">
                                        <span>{{ $number->number }}</span></div>
                                @endforeach
                            </td>
                        @endforeach
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <div class="control-panel">
        <form class="digits-form">
            <label class="radio" data-value="0">
                <input type="radio" name="showed-digits" value="0" checked>
                <b></b>
                <span></span>
            </label>
            <label class="radio" data-value="2">
                <input type="radio" name="showed-digits" value="2">
                <b></b><span></span>
            </label>
            <label class="radio" data-value="3">
                <input type="radio" name="showed-digits" value="3">
                <b></b><span></span>
            </label>
        </form>
        <div class="buttons-wrapper">
            <span class="zoom-in-button"><i class="icon zoom-in-icon"></i>
                <span></span>
            </span>
        </div>
    </div>
</div>
