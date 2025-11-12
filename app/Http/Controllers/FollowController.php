<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function toggle(Request $request, Movie $movie)
    {
        $user = Auth::user();
        if (!$user) {
            if ($request->wantsJson()) return response()->json(['status'=>'unauthenticated'], 401);
            return redirect()->route('login');
        }
        $exists = Follow::where('user_id', $user->id)->where('movie_id', $movie->movie_id)->exists();
        if ($exists) {
            Follow::where('user_id', $user->id)->where('movie_id', $movie->movie_id)->delete();
            $following = false;
        } else {
            Follow::create(['user_id'=>$user->id, 'movie_id'=>$movie->movie_id]);
            $following = true;
        }
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status'=>'ok','following'=>$following]);
        }
        return back();
    }
}

