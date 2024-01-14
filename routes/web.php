<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Url\UrlShortenerController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::post('/shorten', [UrlShortenerController::class, 'shorten']);
Route::get('/r/{hash}', [UrlShortenerController::class, 'redirect']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::view('/{any}', 'dashboard')
    ->where('any', '.*');




