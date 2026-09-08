<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MovieController extends Controller
{
    public function index()
    {
        return view('admincp.movie.index', ['movies' => Movie::with(['genre', 'episodes'])->latest()->paginate(20)]);
    }

    public function create() { return view('admincp.movie.form', $this->formData(new Movie)); }

    public function store(Request $request)
    {
        $movie = Movie::create($this->validated($request));
        return redirect()->route('admin.movies.edit', $movie)->with('status', 'Đã tạo phim. Hãy thêm tập phim.');
    }

    public function edit(Movie $movie) { return view('admincp.movie.form', $this->formData($movie)); }

    public function update(Request $request, Movie $movie)
    {
        $movie->update($this->validated($request, $movie));
        return back()->with('status', 'Đã cập nhật phim.');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->route('admin.movies.index')->with('status', 'Đã xóa phim.');
    }

    private function validated(Request $request, Movie $movie = null): array
    {
        $data = $request->validate([
            'movie_name' => ['required', 'string', 'max:255'],
            'original_name' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('tbl_movie', 'slug')->ignore($movie ? $movie->movie_id : null, 'movie_id')],
            'image' => ['required', 'string', 'max:255'], 'backdrop' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'], 'trailer' => ['nullable', 'url', 'max:255'],
            'type' => ['required', Rule::in(['movie', 'series'])], 'release_year' => ['nullable', 'integer', 'between:1888,2100'],
            'duration' => ['nullable', 'integer', 'min:1'], 'rating' => ['nullable', 'numeric', 'between:0,10'],
            'cat_id' => ['nullable', 'exists:tbl_category,cat_id'], 'genre_id' => ['nullable', 'exists:tbl_genre,genre_id'],
            'country_id' => ['nullable', 'exists:tbl_country,country_id'], 'featured' => ['nullable', 'boolean'], 'status' => ['nullable', 'boolean'],
        ]);
        $data['slug'] = $data['slug'] ?: Str::slug($data['movie_name']);
        $data['featured'] = $request->boolean('featured'); $data['status'] = $request->boolean('status');
        return $data;
    }

    private function formData(Movie $movie): array
    {
        return ['movie' => $movie, 'genres' => Genre::orderBy('genre_name')->get(), 'countries' => Country::orderBy('country_name')->get(), 'categories' => Category::orderBy('cat_name')->get()];
    }
}
