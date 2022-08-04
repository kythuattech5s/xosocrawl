<div data-id="dd" class="col-firstlast">
    <table class="firstlast-mb fl">
       <tbody>
          <tr class="header">
             <th>Đầu</th>
             <th>Đuôi</th>
          </tr>
        @foreach($lottoRecord->headTail()->getHeads() as $key => $numbers)
          <tr>
             <td class="clnote">{{$key}}</td>
             <td class="v-loto-dau-0">{!!
                implode(',', array_map(function($number) {
                    return $number->isSpecial()?'<span class="clnote">'.$number->getNumber().'</span>': $number->getNumber();
                }, $numbers))
            !!}</td>
          </tr>
        @endforeach
       </tbody>
    </table>
    <table class="firstlast-mb fr">
       <tbody>
          <tr class="header">
             <th>Đầu</th>
             <th>Đuôi</th>
          </tr>
          @foreach($lottoRecord->headTail()->getTails() as $key => $numbers)
          <tr>
             <td class="v-loto-dau-0">{!!
                implode(',', array_map(function($number) {
                    return $number->isSpecial()?'<span class="clnote">'.$number->getNumber().'</span>': $number->getNumber();
                }, $numbers))
            !!}</td>
            <td class="clnote">{{$key}}</td>
          </tr>
        @endforeach
       </tbody>
    </table>
 </div>