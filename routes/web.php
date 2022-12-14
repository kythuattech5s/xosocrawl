
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    ResponseCache::clear();
    echo '<pre>';
    var_dump(__LINE__);
    die();
    echo '</pre>';
});

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    'namespace' => 'App\Http\Controllers'
], function () {
    ResponseCache::clear();
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('convert-thu-cong-du-lieu-crawl', 'HomeController@convertThuCongDuLieuCrawl');
    Route::get('cronimg', array('uses' => 'CronImgController@convertImg'));
    Route::get('cronmail', 'CronMailController@cronmail');

    Route::prefix('statistic')->group(function () {
        Route::get('loto-gan', 'StaticalCrawlController@staticalLoganProvince');
        Route::match(['get', 'post'],'tansuat-loto-full', 'StaticalCrawlController@frequencyFull');
    });
    Route::prefix('redirect')->group(function () {
        Route::get('outbn', 'RedirectOutLinkController@outBanner');
        Route::get('out', 'RedirectOutLinkController@outGuessLink');
    });  
    Route::get('thong-ke-dau-duoi-lo-to.html', 'StaticalCrawlController@headAndTailRedirect');
    Route::get('thong-ke-dau-duoi-dac-biet.html', 'StaticalCrawlController@headAndTailDacbietRedirect');
    Route::get('thong-ke-nhanh.html', 'StaticalCrawlController@tkNhanhRedirect');
    Route::get('xo-so-truc-tiep/{prefix}', 'XosoTrucTiepController@view');
    Route::get('tin-tuc/{prefix}', 'NewsController@_view');
    Route::post('ajax/see-more-result', 'StaticalCrawlController@ajaxSeeMoreResult');
    Route::get('ket-qua-xo-so-dien-toan-ngay-{id}', 'PageController@xoSoDienToanTheoNgay')->where(['id' => '\d{1,2}\-\d{1,2}\-\d{4}']);
    Route::match(['get', 'post'], '/thong-tin-thanh-vien-c{id}', array('uses' => 'Auth\AccountController@userShowProfile'))->where('id', '^((?!esystem)[0-9\?\.\-/])*$');
    Route::match(['get', 'post'], '/{link}', array('uses' => 'HomeController@direction'))->where('link', '^((?!esystem)[0-9a-zA-Z\?\.\-/])*$');
});
