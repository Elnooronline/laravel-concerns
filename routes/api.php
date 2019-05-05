<?php
Route::prefix('api')
    ->middleware('api')
    ->namespace('\Elnooronline\LaravelConcerns\Http\Controllers')->group(function () {
        Route::delete('media/{media}', 'MediaController@destroy')
            ->middleware('auth:api')->name('api.media.destroy');
    });
