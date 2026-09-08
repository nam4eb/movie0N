<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EpisodeController extends Controller
{
    public function create(Movie $movie) { return view('admincp.episode.form', compact('movie') + ['episode' => new Episode]); }
    public function store(Request $request, Movie $movie)
    {
        $movie->episodes()->create($this->validated($request, $movie));
        return redirect()->route('admin.movies.edit', $movie)->with('status', 'Đã thêm tập phim.');
    }
    public function edit(Movie $movie, Episode $episode) { abort_unless($episode->movie_id === $movie->movie_id, 404); return view('admincp.episode.form', compact('movie', 'episode')); }
    public function update(Request $request, Movie $movie, Episode $episode) { abort_unless($episode->movie_id === $movie->movie_id, 404); $episode->update($this->validated($request, $movie, $episode)); return redirect()->route('admin.movies.edit', $movie)->with('status', 'Đã cập nhật tập.'); }
    public function destroy(Movie $movie, Episode $episode) { abort_unless($episode->movie_id === $movie->movie_id, 404); $episode->delete(); return back()->with('status', 'Đã xóa tập.'); }
    private function validated(Request $request, Movie $movie, Episode $episode = null): array
    {
        return $request->validate(['eps_num' => ['required','integer','min:1',Rule::unique('tbl_episode')->where(fn($q)=>$q->where('movie_id',$movie->movie_id)->where('server',$request->input('server','Default')))->ignore($episode ? $episode->eps_id : null,'eps_id')], 'title'=>['nullable','string','max:255'], 'server'=>['required','string','max:100'], 'link'=>['required','url','max:2000'], 'status'=>['nullable','boolean']]) + ['status'=>$request->boolean('status')];
    }
}
