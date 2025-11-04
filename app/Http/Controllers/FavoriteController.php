<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class FavoriteController extends Controller
{
    public function toggle(Movie $movie): RedirectResponse
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $exists = $user->favorites()->where('movie_id', $movie->movie_id)->exists();

        if ($exists) {
            $user->favorites()->detach($movie->movie_id);
        } else {
            $user->favorites()->attach($movie->movie_id);
        }

        return back();
    }
}

