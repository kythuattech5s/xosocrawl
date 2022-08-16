<?php
$lottoItemMnCollectionPrev = $lottoItemMnCollection->prev();
$lottoRecordPrev = $lottoItemMnCollectionPrev->getLottoRecord();
?>
@include('xoso.mien_nam.related.result_table_nearest', [
    'lottoItemMnCollection' => $lottoItemMnCollectionPrev,
    'viewRelate' => 'related_news_1',
    'lottoRecord' => $lottoRecordPrev,
])
