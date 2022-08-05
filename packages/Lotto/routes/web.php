<?php
Route::get('xsmb-{id1}-ket-qua-xo-so-mien-bac-{id2}.html', 'Lotto\Http\Controllers\XoSoController@xoSoMienBacCategoryDow')->name('xsmbdow')->where([
    'id1' => 'thu-2|thu-3|thu-4|thu-5|thu-6|thu-7|chu-nhat',
    'id2' => 'thu-2|thu-3|thu-4|thu-5|thu-6|thu-7|chu-nhat',
]);
Route::get('xsmb-{id1}-ket-qua-xo-so-mien-bac-ngay-{id2}.html', 'Lotto\Http\Controllers\XoSoController@xoSoMienBacCategoryDmy')->name('xsmbdmy')->where([
    'id1' => '\d{1,2}\-\d{1,2}\-\d{4}',
]);
