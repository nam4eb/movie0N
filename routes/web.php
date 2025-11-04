<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\IndexController;

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

// Auth routes (login/register/password resets)
Auth::routes();

// Public pages
Route::get('/', [IndexController::class, 'home'])->name('home');
Route::get('/home', [IndexController::class, 'home']);

// Movies listing and detail (dynamic)
Route::get('/movies', [IndexController::class, 'movies'])->name('movies.index');
Route::get('/movies/{movie:movie_id}', [IndexController::class, 'movieDetail'])->name('movies.show');

// TV Shows (filter by series category)
Route::get('/tv-shows', [IndexController::class, 'tvShows'])->name('tvshows.index');

// News pages (New & popular)
Route::get('/news', [\App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [\App\Http\Controllers\NewsController::class, 'show'])->name('news.show');

// Comments
Route::post('/movies/{movie:movie_id}/comments', [\App\Http\Controllers\CommentController::class, 'store'])
    ->middleware('auth')
    ->name('comments.store');

// Playlists
Route::get('/playlists', [\App\Http\Controllers\PlaylistController::class, 'index'])->name('playlists.index');
Route::post('/playlists', [\App\Http\Controllers\PlaylistController::class, 'store'])->name('playlists.store');
Route::post('/playlists/{playlist}/movies/{movie:movie_id}', [\App\Http\Controllers\PlaylistController::class, 'addMovie'])->name('playlists.movies.add');

// User Profile
Route::get('/profile', [\App\Http\Controllers\UserController::class, 'show'])->name('profile.show');
Route::put('/profile', [\App\Http\Controllers\UserController::class, 'update'])->name('profile.update');

Route::get('/watch-movie', [IndexController::class, 'watchMovie'])->name('movie.watch');

// Backward compatible alias for old route name used in some views
Route::get('/movie-detail', fn () => redirect()->route('movies.index'))->name('movie.detail');

// Favorites toggle
Route::post('/favorites/{movie:movie_id}/toggle', [\App\Http\Controllers\FavoriteController::class, 'toggle'])
    ->middleware('auth')
    ->name('favorites.toggle');

// Compatibility for legacy links like index.php?module=movie-detail
Route::get('/index.php', function (Request $request) {
    $module = $request->query('module');
    return match ($module) {
        'movie-detail' => redirect()->route('movies.index'),
        'home' => redirect()->route('home'),
        default => redirect()->route('home'),
    };
});

// User pages
Route::get('/favorites', [IndexController::class, 'favorites'])->name('favorites')->middleware('auth');

// Admin routes (disabled for now)
// Route::resource('/category', CategoryController::class);
// Route::resource('/movie', MovieController::class);
// Route::resource('/genre', GenreController::class);
// Route::resource('/country', CountryController::class);
// Route::resource('/episode', EpisodeController::class);
