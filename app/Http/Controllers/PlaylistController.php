<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $playlists = Auth::user()->playlists()->withCount('movies')->get();
        return view('pages.playlists.index', compact('playlists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Auth::user()->playlists()->create($request->only('name'));

        return back()->with('success', 'Playlist created successfully.');
    }

    public function addMovie(Request $request, Playlist $playlist, Movie $movie)
    {
        $playlist->movies()->syncWithoutDetaching($movie->movie_id);

        return back()->with('success', "'{$movie->movie_name}' added to '{$playlist->name}'.");
    }
}
