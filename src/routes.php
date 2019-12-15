<?php
// Route::post('simplexhrRequest', 'Bertvthul\Simplexhr\SimplexhrController@xhrRequestPost')->name('simplexhrRequest.post');
Route::group(['middleware' => ['web']], function () {
	Route::post('simplexhrRequest', 'Bertvthul\Simplexhr\SimplexhrController@call');
});
