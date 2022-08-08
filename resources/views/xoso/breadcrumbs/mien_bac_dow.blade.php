 <h2 class="tit-mien clearfix">
    <strong>
        <a class="title-a" href="{{$lottoCategory->slug}}" title="{{$lottoCategory->short_name}}">{{$lottoCategory->short_name}}</a>
      » 
      <a class="title-a" href="{{$lottoCategory->linkDayOfWeek($lottoRecord)}}" title="{{$lottoCategory->short_name}} {{Support::getDayOfWeek($lottoRecord->created_at)}}">{{$lottoCategory->short_name}} {{Support::getDayOfWeek($lottoRecord->created_at)}}</a> 
      » 
      <a class="title-a" href="{{$lottoCategory->linkDate($lottoRecord)}}" title="{{$lottoCategory->short_name}} {{Support::format($lottoRecord->created_at,'j-n-Y')}}">{{$lottoCategory->short_name}} {{Support::format($lottoRecord->created_at,'j-n-Y')}}</a>
    </strong>
  </h2>