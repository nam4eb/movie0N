<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Episode;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function home()
    {
        $featured = Movie::published()->featured()->latest()->take(5)->get();
        $latest = Movie::published()->latest()->take(12)->get();
        $series = Movie::published()->where('type', 'series')->latest()->take(8)->get();

        return view('pages.home', compact('featured', 'latest', 'series'));
    }

    public function movies(Request $request)
    {
        $movies = Movie::published()
            ->with(['genre', 'country'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = trim($request->input('q'));
                $query->where(function ($query) use ($term) {
                    $query->where('movie_name', 'like', "%{$term}%")
                        ->orWhere('original_name', 'like', "%{$term}%");
                });
            })
            ->when($request->filled('genre'), fn ($query) => $query->where('genre_id', $request->input('genre')))
            ->when($request->filled('country'), fn ($query) => $query->where('country_id', $request->input('country')))
            ->when(in_array($request->input('type'), ['movie', 'series'], true), fn ($query) => $query->where('type', $request->input('type')))
            ->latest()->paginate(20)->withQueryString();

        return view('pages.movie', [
            'movies' => $movies,
            'genres' => Genre::active()->orderBy('genre_name')->get(),
            'countries' => Country::active()->orderBy('country_name')->get(),
        ]);
    }

    public function movieDetail(Movie $movie)
    {
        abort_unless($movie->status, 404);
        $movie->load(['genre', 'country', 'episodes' => fn ($query) => $query->active()->orderBy('eps_num')]);
        $related = Movie::published()->where($movie->getKeyName(), '!=', $movie->getKey())
            ->where('genre_id', $movie->genre_id)->take(4)->get();

        return view('pages.movie-detail', compact('movie', 'related'));
    }

    public function watchMovie(Movie $movie, Episode $episode = null)
    {
        abort_unless($movie->status, 404);
        $episodes = $movie->episodes()->active()->orderBy('eps_num')->get();
        $episode = $episode ?: $episodes->first();
        abort_if(!$episode || $episode->movie_id !== $movie->movie_id, 404);

        return view('pages.watch-movie', compact('movie', 'episode', 'episodes'));
    }

    public function genre(Genre $genre)
    {
        return $this->catalog($genre->movies()->published(), $genre->genre_name);
    }

    public function country(Country $country)
    {
        return $this->catalog($country->movies()->published(), $country->country_name);
    }

    private function catalog($query, string $title)
    {
        return view('pages.category', [
            'title' => $title,
            'movies' => $query->latest()->paginate(20),
        ]);
    }
}
