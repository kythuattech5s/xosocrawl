<?php
Route::group(['prefix'=>'basecrawler','middleware' => 'web','namespace'=>'crawlmodule\basecrawler\Controllers'],function(){
    Route::get('/do-crawl/{type}','Controller@doCrawl');
});