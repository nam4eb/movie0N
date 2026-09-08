<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Auth;

//Admin Controllers
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\EpisodeController;

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

/**
 * Verification email Routes
 */
Route::get('/', [IndexController::class, 'home'])->name('home');
Route::get('/movies', [IndexController::class, 'movies'])->name('movies.index');
Route::get('/movies/{movie:slug}', [IndexController::class, 'movieDetail'])->name('movies.show');
Route::get('/movies/{movie:slug}/watch/{episode?}', [IndexController::class, 'watchMovie'])->name('movies.watch');
Route::get('/genre/{genre}', [IndexController::class, 'genre'])->name('genres.show');
Route::get('/country/{country}', [IndexController::class, 'country'])->name('countries.show');

Auth::routes();


Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('movies', MovieController::class)->except('show');
    Route::resource('movies.episodes', EpisodeController::class)->except(['index', 'show']);
});
