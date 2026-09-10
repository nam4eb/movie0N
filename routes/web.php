<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;

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

Route::get('/',[IndexController::class, 'home'] );

Route::get('/home',[IndexController::class, 'home'] );

Route::get('/movie-detail',[IndexController::class, 'movieDetail'] );

Route::get('/watch-movie',[IndexController::class, 'watchMovie'] );

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

//Admin Route
Route::resource('/category',CategoryController::class );

Route::resource('/movie',MovieController::class );

Route::resource('/genre',GenreController::class );

Route::resource('/country',CountryController::class );

Route::resource('/episode',EpisodeController::class );
