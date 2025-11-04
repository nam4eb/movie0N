<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;

class CommentController extends Controller
{
    public function store(Request $request, Movie $movie)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $movie->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
            'status' => 1, // Automatically approve comments for now
        ]);

        return back()->with('success', 'Your comment has been posted.');
    }
}
