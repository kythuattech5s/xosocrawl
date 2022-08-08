<div id="ajax-result-table">
    @foreach($relateRecords as $record)
    @include('xoso.mien_bac.result_table_nearest',['lottoRecord'=>$record,'viewRelate'=>null])
 @endforeach
</div>
<div class="dnone" id="hidden-paginate-links">
    {!!$relateRecords->links()!!}
</div>
