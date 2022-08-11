<?php
$lottoItemMnCollectionPrev = $lottoItemMnCollection->prev();
?>
@include('xoso.mien_nam.related.result_table_nearest', [
    'lottoItemMnCollection' => $lottoItemMnCollectionPrev,
    'viewRelate' => 'related_news_1',
])



{{-- <div id="box-result-more" lotto-record-id="{{ $lottoRecordPrevPrev->id ? $lottoRecordPrevPrev->id : 0 }}"
    lotto-type="{{ $typeRelated }}"></div>
<button class="btn-see-more magb10" id="result-see-more" value="Xem thêm" data-page="2" data-province="mb">Xem thêm</button>

<div class="box box-html s-content">
    {!! $lottoItem->content !!}
</div> --}}
