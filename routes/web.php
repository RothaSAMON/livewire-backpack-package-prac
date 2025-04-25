<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'phone-catalog', 'middleware' => ['web']], function () {
    // Define your routes here
    // Example:
    // Route::get('/', 'Rotha\PhoneCatalog\Http\Controllers\PhoneCatalogController@index')->name('phone-catalog.index');
});