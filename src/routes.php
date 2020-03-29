<?php

Route::group(['middleware' => [config('simplexhr.middleware')]], function () {
	Route::post('simplexhrRequest', 'Bertvthul\Simplexhr\SimplexhrController@call');
});
