<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class FavoriteController extends Controller
{
    public function toggle(Movie $movie, \Illuminate\Http\Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['status' => 'unauthenticated'], 401);
            }
            return redirect()->route('login');
        }

        $exists = $user->favorites()->wherePivot('movie_id', $movie->movie_id)->exists();

        if ($exists) {
            $user->favorites()->detach($movie->movie_id);
            $favorited = false;
        } else {
            $user->favorites()->attach($movie->movie_id);
            $favorited = true;
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 'ok', 'favorited' => $favorited]);
        }
        return back();
    }
}

