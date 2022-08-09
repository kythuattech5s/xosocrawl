<div data-id="kq" class="one-city" data-region="1">
    <table class="kqmb extendable {{ isset($prefixPath) && $prefixPath == 'mien-bac' ? '' : 'kqtinh' }}">
        <tbody>
            @if ($lottoRecord->description)
                <tr>
                    <td colspan="13" class="v-giai madb">
                        <span class="v-madb"> {{ $lottoRecord->description }} </span>
                    </td>
                </tr>
            @endif
            @foreach ($lottoRecord->lottoResultDetails->groupBy('no_prize') as $no => $details)
                <tr class="{{ \Lotto\Enums\NoPrize::getClassTr($no) }}">
                    <td class="txt-giai">{{ $no == 0 ? 'ĐB' : 'Giải ' . $no }}</td>
                    <td class="v-giai number ">
                        @foreach ($details as $idx => $detail)
                            <span data-nc="5"
                                class="v-g{{ $no }}-{{ $idx }} ">{{ $detail->number }}</span>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="control-panel">
        <form class="digits-form">
            <label class="radio" data-value="0">
                <input type="radio" name="showed-digits" value="0">
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
