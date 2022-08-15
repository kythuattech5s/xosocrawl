<div id="ajax-result-table">
    @foreach ($relateRecords as $record)
        @php
            $lottoItemMnCollection = $record->toLottoItemMnCollection();
        @endphp
        @include('xoso.mien_nam.related.result_table_nearest', [
            'lottoRecord' => $record,
            'lottoItemMnCollection' => $lottoItemMnCollection,
            'viewRelate' => null,
            'typeRelated' => $typeRelated,
            'lottoCategory' => $lottoCategory,
        ])
    @endforeach
</div>
<div class="dnone" id="hidden-paginate-links">
    {!! $relateRecords->links() !!}
</div>
