<?php $lottoRecordPrev = $lottoRecord->prev(false);
$linkPrefix = null; ?>
@include('xoso.mien_bac.related.result_table_nearest', [
    'lottoRecord' => $lottoRecordPrev,
    'viewRelate' => 'related_news_1',
])
