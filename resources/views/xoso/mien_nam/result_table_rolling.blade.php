<?php
use Lotto\Helpers\RollingHelper;
$result = RollingHelper::getMXPrizes($lottoCategory->id);
$lottoItems = $result->lottoItems;
$prizes = $result->prizes;
$count = count($lottoItems);
$classCount = $count == 3 ? 'three' : ($count == 4 ? 'four' : 'two');
?>
<div data-id="kq" class="{{ $classCount }}-city rolling-table" data-region="3">
    <table class="col{{ $classCount }}city colgiai extendable">
        <tbody>

            <tr class="gr-yellow">
                <th class="first"></th>
                @foreach ($lottoItems as $idx => $lottoItem)
                    <th data-pid="4"><a href="{{ $lottoItem->getSlug() }}" title="Xổ số {{ $lottoItem->name }}"
                            class="underline bold">{{ $lottoItem->name }}</a>
                    </th>
                @endforeach
            </tr>
            @foreach ($prizes as $idx => $prize)
                <tr class="g{{ $prize->getClassCss() }}">
                    <td>{{ $prize->getShortName() }}</td>
                    @foreach ($lottoItems as $lottoItem)
                        <td data-code="{{ strtoupper($lottoItem->code) }}">
                            @for ($i = 0; $i < $prize->getNumPrize(); $i++)
                                <div class="v-g{{ $prize->getClassCss() }} v-giai number imgloadig"
                                    data-nonum="{{ $prize->getNoNumber() }}">
                                    <span class=""></span>
                                </div>
                            @endfor
                        </td>
                    @endforeach
                </tr>
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
