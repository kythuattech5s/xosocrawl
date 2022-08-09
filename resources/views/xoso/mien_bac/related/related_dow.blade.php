<?php $lottoRecordPrev = $lottoRecord->prev(false, true);
$linkPrefix = null; ?>
@include('xoso.mien_bac.related.result_table_nearest', [
    'lottoRecord' => $lottoRecordPrev,
    'viewRelate' => 'related_news_1',
])
<?php $lottoRecordPrevPrev = $lottoRecordPrev->prev(false, true);
$linkPrefix = null; ?>
@include('xoso.mien_bac.related.result_table_nearest', [
    'lottoRecord' => $lottoRecordPrevPrev,
    'viewRelate' => 'related_news_2',
])
<div id="box-result-more" lotto-record-id="{{ $lottoRecordPrevPrev->id ? $lottoRecordPrevPrev->id : 0 }}"
    lotto-type="{{ $typeRelated }}"></div>
<button class="btn-see-more magb10" id="result-see-more" value="Xem thêm" data-page="2" data-province="mb">Xem thêm</button>

<div class="box box-html s-content">
    {!! $lottoCategory->getContentDow($lottoRecord) !!}
</div>
