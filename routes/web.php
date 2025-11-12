<?php

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('language.switch');


use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\IndexController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Include Breeze auth routes
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}

// Public pages
Route::get('/', [IndexController::class, 'home'])->name('home');
Route::get('/home', [IndexController::class, 'home']);

// Search suggestions API for overlay
Route::get('/search/suggest', [IndexController::class, 'searchSuggestions'])->name('search.suggest');


// Full search results page
Route::get('/search', [IndexController::class, 'search'])->name('search.full');

// Movies listing and detail (dynamic)
Route::get('/movies', [IndexController::class, 'movies'])->name('movies.index');
Route::get('/movies/{movie:movie_id}', [IndexController::class, 'movieDetail'])->name('movies.show');

// Genres
Route::get('/genres', [IndexController::class, 'genresIndex'])->name('genres.index');
Route::get('/genres/{genre:genre_id}', [IndexController::class, 'genreShow'])->name('genres.show');

// TV Shows (filter by series category)
Route::get('/tv-shows', [IndexController::class, 'tvShows'])->name('tvshows.index');

// News pages (New & popular)
Route::get('/news', [\App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [\App\Http\Controllers\NewsController::class, 'show'])->name('news.show');

// Public routes that might have authenticated states
Route::get('/playlists', [\App\Http\Controllers\PlaylistController::class, 'index'])->name('playlists.index');
Route::get('/playlists/{playlist}', [\App\Http\Controllers\PlaylistController::class, 'show'])->name('playlists.show');
Route::get('/movies/{movie:movie_id}/watch', [IndexController::class, 'watchMovie'])->name('movie.watch');

// Backward compatible alias for old route name used in some views
Route::get('/movie-detail', fn () => redirect()->route('movies.index'))->name('movie.detail');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Comments
    Route::post('/movies/{movie:movie_id}/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');

    // Playlists
    Route::post('/playlists', [\App\Http\Controllers\PlaylistController::class, 'store'])->name('playlists.store');
    Route::post('/playlists/{playlist}/movies/{movie:movie_id}', [\App\Http\Controllers\PlaylistController::class, 'addMovie'])->name('playlists.movies.add');
    Route::post('/playlists/{playlist}/movies', [\App\Http\Controllers\PlaylistController::class, 'addMovieById'])->name('playlists.movies.add.body');

    // User Profile
    Route::get('/profile', [\App\Http\Controllers\UserController::class, 'show'])->name('profile.show');
    Route::put('/profile', [\App\Http\Controllers\UserController::class, 'update'])->name('profile.update');

    // Favorites toggle
    Route::post('/favorites/{movie:movie_id}/toggle', [\App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Follow/unfollow a movie
    Route::post('/movies/{movie:movie_id}/follow', [\App\Http\Controllers\FollowController::class, 'toggle'])->name('movies.follow');

    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [\App\Http\Controllers\NotificationController::class, 'index'])->name('index');
    });

    // Save watching progress (AJAX)
    Route::post('/progress', [\App\Http\Controllers\ProgressController::class, 'store'])->name('progress.store');

    // User pages
    Route::get('/favorites', [IndexController::class, 'favorites'])->name('favorites');

    // Rate a movie
    Route::post('/movies/{movie:movie_id}/rate', [\App\Http\Controllers\RatingController::class, 'store'])->name('movies.rate');
});

// Compatibility for legacy links like index.php?module=movie-detail
Route::get('/index.php', function (Request $request) {
    $module = $request->query('module');
    return match ($module) {
        'movie-detail' => redirect()->route('movies.index'),
        'home' => redirect()->route('home'),
        default => redirect()->route('home'),
    };
});


// Public user profile
Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'publicProfile'])->name('users.profile');
