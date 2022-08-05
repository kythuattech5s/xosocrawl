<?php
Route::group(['prefix' => 'basiccomment', 'middleware' => 'web', 'namespace' => 'basiccomment\comment\Controllers'], function () {
	Route::get('/theme/{source}/{file}','ManageCommentController@file');
	Route::post('/load-user-tag-list', 'ManageCommentController@loadUserTagList');
	Route::post('/send-comment', 'ManageCommentController@sendComment');
	Route::get('/load-comment', 'ManageCommentController@loadComment');
	Route::get('/load-form-comment', 'ManageCommentController@loadFormComment');
	Route::get('/send-like-comment', 'ManageCommentController@sendLikeComment');
	Route::post('/send-comment-report', 'ManageCommentController@sendCommentReport');
	Route::get('/load-comment-active', 'ManageCommentController@loadCommentActive');
});