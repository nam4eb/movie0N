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

    public function show(Playlist $playlist)
    {
        if ($playlist->user_id !== Auth::id() && !$playlist->is_public) {
            abort(403);
        }
        $movies = $playlist->movies()->latest()->paginate(12);
        return view('pages.playlists.show', compact('playlist','movies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Auth::user()->playlists()->create($request->only('name'));

        return back()->with('success', 'Playlist created successfully.');
    }

    // Original: add by route-model-binding /playlists/{playlist}/movies/{movie}
    public function addMovie(Playlist $playlist, Movie $movie, Request $request)
    {
        if ($playlist->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền sửa playlist này.');
        }
        $playlist->movies()->syncWithoutDetaching([$movie->movie_id]);
        $message = "{$movie->movie_name} đã được thêm vào playlist {$playlist->name}.";
        return response()->json(['status' => 'ok', 'message' => $message]);
    }

    // Alternative endpoint: POST /playlists/{playlist}/movies with movie_id in body
    public function addMovieById(Request $request, Playlist $playlist)
    {
        if ($playlist->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền sửa playlist này.');
        }
        $request->validate([
            'movie_id' => 'required|integer',
        ]);
        $movie = Movie::where('movie_id', $request->input('movie_id'))->first();
        if (!$movie) {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy phim.'], 404);
        }
        $playlist->movies()->syncWithoutDetaching([$movie->movie_id]);
        $message = "{$movie->movie_name} đã được thêm vào playlist {$playlist->name}.";
        return response()->json(['status' => 'ok', 'message' => $message]);
    }
}
