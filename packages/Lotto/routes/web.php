<?php
Route::get('xsmb-{id1}-ket-qua-xo-so-mien-bac-{id2}', 'Lotto\Http\Controllers\XoSoController@xoSoMienBacCategoryDow')->name('xsmbdow')->where([
    'id1' => 'thu-2|thu-3|thu-4|thu-5|thu-6|thu-7|chu-nhat',
    'id2' => 'thu-2|thu-3|thu-4|thu-5|thu-6|thu-7|chu-nhat',
]);
Route::get('xsmb-{id1}-ket-qua-xo-so-mien-bac-ngay-{id2}', 'Lotto\Http\Controllers\XoSoController@xoSoMienBacCategoryDmy')->name('xsmbdmy')->where([
    'id1' => '\d{1,2}\-\d{1,2}\-\d{4}',
]);


Route::get('xsmn-{id1}-sxmn-ket-qua-xo-so-mien-nam-{id2}', 'Lotto\Http\Controllers\XoSoController@xoSoMienNamCategoryDow')->name('xsmndow')->where([
    'id1' => 'thu-2|thu-3|thu-4|thu-5|thu-6|thu-7|chu-nhat',
    'id2' => 'thu-2|thu-3|thu-4|thu-5|thu-6|thu-7|chu-nhat',
]);
Route::get('xsmn-{id1}-ket-qua-xo-so-mien-nam-ngay-{id2}', 'Lotto\Http\Controllers\XoSoController@xoSoMienNamCategoryDmy')->name('xsmndmy')->where([
    'id1' => '\d{1,2}\-\d{1,2}\-\d{4}',
]);

Route::get('xsmt-{id1}-sxmt-ket-qua-xo-so-mien-trung-{id2}', 'Lotto\Http\Controllers\XoSoController@xoSoMienTrungCategoryDow')->name('xsmndow')->where([
    'id1' => 'thu-2|thu-3|thu-4|thu-5|thu-6|thu-7|chu-nhat',
    'id2' => 'thu-2|thu-3|thu-4|thu-5|thu-6|thu-7|chu-nhat',
]);
Route::get('xsmt-{id1}-ket-qua-xo-so-mien-trung-ngay-{id2}', 'Lotto\Http\Controllers\XoSoController@xoSoMienTrungCategoryDmy')->name('xsmndmy')->where([
    'id1' => '\d{1,2}\-\d{1,2}\-\d{4}',
]);
