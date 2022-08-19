<?php
use Lotto\Helpers\RollingHelper;
?>

<div data-id="kq" class="one-city rolling-table" data-region="1">
    <table
        class="custom kqmb extendable  {{ !isset($prefixPath) || ($prefixPath == 'mien-bac' || $prefixPath == 'mien_bac') ? '' : 'kqtinh' }}">
        <tbody>
            <tr>
                <td colspan="13" class="v-giai madb">
                    <span class="v-madb"> </span>
                </td>
            </tr>
            @foreach (RollingHelper::getMBPrizes() as $prize)
                <tr
                    class="{{ $prize->getIndex() % 2 == 0 ? 'bg_ef' : '' }} g{{ $prize->getClassCss() }} {{ $prize->getClassCss() }}">
                    <td class="txt-giai">{{ $prize->getName() }}</td>
                    <td class="v-giai number " data-code="MB">
                        @for ($i = 0; $i < $prize->getNumPrize(); $i++)
                            <span data-nc="5" data-nonum="{{ $prize->getNoNumber() }}"
                                class="v-g{{ $prize->getIndex() }}-{{ $i }} imgloadig"></span>
                        @endfor
                    </td>
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
