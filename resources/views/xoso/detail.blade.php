@extends('index')
@section('main')
@include('partials.link_du_doan')
    <div class="box">
       <div class="bg_gray">
          <div class=" opt_date_full clearfix">
            @php
                $prevLottoRecord = $lottoRecord->prev();
                $nextLottoRecord = $lottoRecord->next();
            @endphp
            @if($prevLottoRecord)
                <a href="{{$prevLottoRecord->link($linkPrefix)}}" class="ic-pre fl" title="Kết quả xổ số {{$prevLottoRecord->name}} ngày {{Support::format($prevLottoRecord->created_at)}}"></a>
            @endif
             <label><strong>{{Support::getDayOfWeek($lottoRecord->created_at)}}</strong> - <input type="text" class="nobor hasDatepicker" value="{{Support::format($lottoRecord->created_at)}}" id="searchDate"><span class="ic ic-calendar"></span></label>
             @if($nextLottoRecord)
             <a href="{{$nextLottoRecord->link($linkPrefix)}}" class="ic-next" title="Kết quả xổ số {{$nextLottoRecord->name}} ngày {{Support::format($nextLottoRecord->created_at)}}"></a>
             @endif
          </div>
       </div>
    </div>
    
    <div class="box">
       @include('xoso.breadcrumbs.base')
       <div id="load_kq_tinh_0">
          
            @include('xoso.result_table')
          
          <div class="txt-center">
             <div class="center">
                <a class="ban-link" href="/redirect/out?token=I%2FZxoQFsuUjDev87POoC9PSveDZOsQOylNFoAc3oAoA%3D" title="" rel="nofollow" target="_blank" data-pos="ban_square"><img src="theme/frontend/images/tuvan.png"></a> 
             </div>
          </div>
          @include('xoso.head_tail')
          <div class="clearfix"></div>
          <div class="bg_brown clearfix">
             <a rel="nofollow" class="conect_out " title="In vé dò" href="https://xoso.me/in-ve-do.html">In
             vé dò</a>
          </div>
       </div>
       @include('xoso.mien_bac.see_more')
    </div>
    <?php $lottoRecordPrev = $lottoRecord->prev() ?>
    @include('xoso.mien_bac.result_table_nearest',['lottoRecord'=>$lottoRecordPrev,'viewRelate'=>'related_news_1'])
    <?php $lottoRecordPrevPrev = $lottoRecordPrev->prev() ?>
    @include('xoso.mien_bac.result_table_nearest',['lottoRecord'=>$lottoRecordPrevPrev,'viewRelate'=>'related_news_2'])
@endsection