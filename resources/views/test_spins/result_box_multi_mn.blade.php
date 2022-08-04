@php
    $countItemActive = count($listActiveTestSpinToday);
@endphp
<div data-id="kq" data-zoom=1 data-sub=0 data-sound=1 class="three-city" data-region="2">
    <table class="colthreecity colgiai extendable">
        <tbody>
            <tr class="gr-yellow">
                <th class="first"></th>
                @foreach ($listActiveTestSpinToday as $itemlistActiveTestSpinToday)
                    <th data-pid="23">
                        <span class="bold">{{Support::show($itemlistActiveTestSpinToday,'province_name')}}</span>
                    </th>
                @endforeach
            </tr>
            <tr class="g8">
                <td>G8</td>
                @for ($i = 0; $i < $countItemActive; $i++)
                    <td>
                        <div data-nc="2" class="v-g8 imgloadig"></div>
                    </td>
                @endfor
            </tr>
            <tr>
                <td>G7</td>
                @for ($i = 0; $i < $countItemActive; $i++)
                    <td>
                        <div data-nc="3" class="v-g7 imgloadig"></div>
                    </td>
                @endfor
            </tr>
            <tr>
                <td>G6</td>
                @for ($i = 0; $i < $countItemActive; $i++)
                    <td>
                        <div data-nc="4" class="v-g6-0 imgloadig"></div>
                        <div data-nc="4" class="v-g6-1 imgloadig"></div>
                        <div data-nc="4" class="v-g6-2 imgloadig"> </div>
                    </td>
                @endfor
            </tr>
            <tr>
                <td>G5</td>
                @for ($i = 0; $i < $countItemActive; $i++)
                    <td>
                        <div data-nc="4" class="v-g5 imgloadig"></div>
                    </td>
                @endfor
            </tr>
            <tr>
                <td>G4</td>
                @for ($i = 0; $i < $countItemActive; $i++)
                    <td>
                        <div data-nc="5" class="v-g4-0 imgloadig"></div>
                        <div data-nc="5" class="v-g4-1 imgloadig"></div>
                        <div data-nc="5" class="v-g4-2 imgloadig"></div>
                        <div data-nc="5" class="v-g4-3 imgloadig"></div>
                        <div data-nc="5" class="v-g4-4 imgloadig"></div>
                        <div data-nc="5" class="v-g4-5 imgloadig"></div>
                        <div data-nc="5" class="v-g4-6 imgloadig"></div>
                    </td>
                @endfor
            </tr>
            <tr>
                <td>G3</td>
                @for ($i = 0; $i < $countItemActive; $i++)
                    <td>
                        <div data-nc="5" class="v-g3-0 imgloadig"></div>
                        <div data-nc="5" class="v-g3-1 imgloadig"></div>
                    </td>
                @endfor
            </tr>
            <tr>
                <td>G2</td>
                @for ($i = 0; $i < $countItemActive; $i++)
                    <td>
                        <div data-nc="5" class="v-g2 imgloadig"></div>
                    </td>
                @endfor
            </tr>
            <tr>
                <td>G1</td>
                @for ($i = 0; $i < $countItemActive; $i++)
                    <td>
                        <div data-nc="5" class="v-g1 imgloadig"></div>
                    </td>
                @endfor
            </tr>
            <tr class="gdb">
                <td>ĐB</td>
                @for ($i = 0; $i < $countItemActive; $i++)
                    <td>
                        <div data-nc="6" class="v-gdb imgloadig"></div>
                    </td>
                @endfor
            </tr>
        </tbody>
    </table>
</div>
<div data-id="dd" class="col-firstlast colthreecity colgiai">
    <table class="firstlast-mn bold">
        <tbody>
            <tr class="header">
                <th class="first">Đầu</th>
                @foreach ($listActiveTestSpinToday as $itemlistActiveTestSpinToday)
                    <th>{{Support::show($itemlistActiveTestSpinToday,'province_name')}}</th>
                @endforeach
            </tr>
            @for ($i = 0; $i < 10; $i++)
                <tr>
                    <td class="clnote bold">{{$i}}</td>
                    <td class="v-loto-dau-{{$i}}"></td>
                    <td class="v-loto-dau-{{$i}}"></td>
                    <td class="v-loto-dau-{{$i}}"></td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>