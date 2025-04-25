<?php

use Illuminate\Support\Facades\Route;
use Rotha\PhoneCatalog\Http\Controllers\Admin\PhoneCrudController;
use Rotha\PhoneCatalog\Http\Livewire\PhoneCatalog;

// Admin routes (Backpack)
Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', backpack_middleware()],
], function () {
    Route::crud('phone', PhoneCrudController::class);
    Route::get('phones', function () {
        return view('phone-catalog::phones');
    })->name('phones.index');
    
    Route::get('phones/{phone}', function ($phone) {
        $phone = \Rotha\PhoneCatalog\Models\Phone::findOrFail($phone);
        return view('phone-catalog::phone-details', compact('phone'));
    })->name('phones.show');
});

// Public routes
Route::group(['middleware' => ['web']], function () {
    Route::get('phones', function () {
        return view('phone-catalog::phones');
    })->name('phones.index');
    
    Route::get('phones/{phone}', function ($phone) {
        $phone = \Rotha\PhoneCatalog\Models\Phone::findOrFail($phone);
        return view('phone-catalog::phone-details', compact('phone'));
    })->name('phones.show');
});