<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Movie $movie)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:10',
        ]);

        $movie->ratings()->updateOrCreate(
            ['user_id' => Auth::id()],
            ['rating' => $request->rating]
        );

        return back()->with('success', 'Your rating has been saved.');
    }
}

