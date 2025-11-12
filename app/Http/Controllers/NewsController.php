<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Movie;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function index()
    {
        $query = News::where('is_published', true)
            ->orderByDesc('published_at')
            ->orderByDesc('created_at');

        $featuredArticle = $query->first();
        $news = $query->skip(1)->paginate(9);

        // Get top 10 movies this week
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $topMovieIds = DB::table('movie_views')
            ->select('movie_id', DB::raw('COUNT(*) as views'))
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('movie_id')
            ->orderByDesc('views')
            ->limit(10)
            ->pluck('movie_id');

        $popularMovies = Movie::whereIn('movie_id', $topMovieIds)->get();

        // Get top 10 TV shows this week
        $tvSeriesCat = Category::where('cat_name', 'like', '%series%')->orWhere('cat_name', 'like', '%phim bộ%')->first();
        $topTvShowIds = [];
        if ($tvSeriesCat) {
            $topTvShowIds = DB::table('movie_views')
                ->join('tbl_movie', 'movie_views.movie_id', '=', 'tbl_movie.movie_id')
                ->select('movie_views.movie_id', DB::raw('COUNT(*) as views'))
                ->where('tbl_movie.cat_id', $tvSeriesCat->cat_id)
                ->whereBetween('movie_views.created_at', [$startOfWeek, $endOfWeek])
                ->groupBy('movie_views.movie_id')
                ->orderByDesc('views')
                ->limit(10)
                ->pluck('movie_views.movie_id');
        }

        $popularTvShows = Movie::whereIn('movie_id', $topTvShowIds)->get();

        return view('pages.news.index', compact('featuredArticle', 'news', 'popularMovies', 'popularTvShows'));
    }

    public function show(string $slug)
    {
        $article = News::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('pages.news.show', compact('article'));
    }
}

