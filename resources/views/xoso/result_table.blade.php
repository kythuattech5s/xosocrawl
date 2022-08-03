<table class="kqmb extendable">
    <tbody>
       <tr>
          <td colspan="13" class="v-giai madb">
             <span class="v-madb"> {{$lottoRecord->description}} </span>
          </td>
       </tr>
       @foreach($lottoRecord->lottoResultDetails->groupBy('no_prize') as $no => $details)
       <tr class="{{\Lotto\Enums\NoPrize::getClassTr($no)}}">
          <td class="txt-giai">{{$no == 0?'ĐB':'Giải '.$no}}</td>
          <td class="v-giai number ">
            @foreach($details as $idx=> $detail)
               <span data-nc="5" class="v-g{{$no}}-{{$idx}} ">{{$detail->number}}</span>
            @endforeach
        </td>
       </tr>
       @endforeach
    </tbody>
 </table>