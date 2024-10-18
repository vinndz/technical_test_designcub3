<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;



Route::get("/", [HomeController::class, "index"]);


Route::get('getProvince', [HomeController::class, 'getProvince'])->name('province.index');
Route::get('getCity/{id}', [HomeController::class, 'getCity']);
Route::get('getDistrict/{id}', [HomeController::class, 'getDistrict']);
Route::get('getSubdistrict/{id}', [HomeController::class, 'getSubdistrict']);


Route::post('storeSubscription', [HomeController::class, 'storeSubscription'])->name('subscription.store');




