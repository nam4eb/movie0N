<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    // Home page
    public function home()
    {
        $carouselMovies = Movie::latest()->take(5)->get();

        // Fetch categories & country to dynamically find their IDs
        $movieCat = Category::where('cat_name', 'like', '%movie%')->first();
        $tvSeriesCat = Category::where('cat_name', 'like', '%series%')->first();
        $korea = Country::where('country_name', 'like', '%korea%')->first();

        $topMovies = $movieCat ? Movie::where('cat_id', $movieCat->cat_id)->latest()->take(10)->get() : collect();
        $topTvSeries = $tvSeriesCat ? Movie::where('cat_id', $tvSeriesCat->cat_id)->latest()->take(10)->get() : collect();
        $topKoreanTvSeries = ($tvSeriesCat && $korea)
            ? Movie::where('cat_id', $tvSeriesCat->cat_id)->where('country_id', $korea->country_id)->latest()->take(10)->get()
            : collect();

        // Coming soon: only 5
        $comingSoonMovies = Movie::where('status', 0)->latest()->take(5)->get();

        // Top movies this month by view count (movie_views table)
        $startMonth = now()->startOfMonth();
        $endMonth = now()->endOfMonth();
        $topMoviesThisMonth = \DB::table('movie_views')
            ->select('movie_id', \DB::raw('COUNT(*) as views'))
            ->whereBetween('created_at', [$startMonth, $endMonth])
            ->groupBy('movie_id')
            ->orderByDesc('views')
            ->limit(5)
            ->get();
        $topMovieIds = $topMoviesThisMonth->pluck('movie_id')->all();
        $topMoviesMonthModels = Movie::whereIn('movie_id', $topMovieIds)->get()->keyBy('movie_id');
        $topMoviesThisMonth = $topMoviesThisMonth->map(function ($row) use ($topMoviesMonthModels) {
            $m = $topMoviesMonthModels->get($row->movie_id);
            return $m ? (object) ['movie' => $m, 'views' => $row->views] : null;
        })->filter();

        $playlists = Auth::check() ? Auth::user()->playlists : collect();

        return view('pages.home', compact(
            'carouselMovies',
            'topMovies',
            'topTvSeries',
            'topKoreanTvSeries',
            'comingSoonMovies',
            'topMoviesThisMonth',
            'playlists'
        ));
    }

    // Movie detail page (dynamic)
    public function movieDetail(Movie $movie)
    {
        // record a view for current month
        try {
            \DB::table('movie_views')->insert([
                'movie_id' => $movie->movie_id,
                'user_id' => Auth::id(),
                'ip' => request()->ip(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // swallow silently if table doesn't exist yet
        }

        $related = Movie::where('movie_id', '!=', $movie->movie_id)->latest()->take(4)->get();
        $playlists = Auth::check() ? Auth::user()->playlists : collect();

        return view('pages.movie-detail', compact('movie', 'related', 'playlists'));
    }

    // Watch movie page
    public function watchMovie()
    {
        return view('pages.watch-movie');
    }

    // List all movies page (dynamic with pagination)
    public function movies(Request $request)
    {
        $query = Movie::query();

        if ($request->filled('category')) {
            $query->where('cat_id', (int) $request->input('category'));
        }
        if ($request->filled('country')) {
            $query->where('country_id', (int) $request->input('country'));
        }
        if ($request->filled('status')) {
            $query->where('status', (int) $request->input('status'));
        }

        switch ($request->get('sort')) {
            case 'name_asc':
                $query->orderBy('movie_name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('movie_name', 'desc');
                break;
            case 'created_asc':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $movies = $query->paginate(12)->appends($request->query());

        $categories = Category::orderBy('cat_name')->get(['cat_id', 'cat_name']);
        $countries = Country::orderBy('country_name')->get(['country_id', 'country_name']);

        return view('pages.movie', compact('movies', 'categories', 'countries'));
    }

    // TV shows listing (filter by series category)
    public function tvShows(Request $request)
    {
        $tvSeriesCat = Category::where('cat_name', 'like', '%series%')->first();
        $query = Movie::query();
        if ($tvSeriesCat) {
            $query->where('cat_id', $tvSeriesCat->cat_id);
        }
        if ($request->filled('country')) {
            $query->where('country_id', (int) $request->input('country'));
        }
        if ($request->filled('status')) {
            $query->where('status', (int) $request->input('status'));
        }
        $query->orderBy('created_at', 'desc');
        $movies = $query->paginate(12)->appends($request->query());

        $categories = Category::orderBy('cat_name')->get(['cat_id', 'cat_name']);
        $countries = Country::orderBy('country_name')->get(['country_id', 'country_name']);

        return view('pages.movie', compact('movies', 'categories', 'countries'));
    }

    // User profile page
    public function profile()
    {
        return view('pages.profile');
    }

    // Favorite movies page (requires auth)
    public function favorites()
    {
        $user = Auth::user();
        $movies = $user ? $user->favorites()->latest()->paginate(12) : collect();
        return view('pages.favorites', compact('movies'));
    }
}
