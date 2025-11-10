<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    // Home page
    public function home()
    {
        $carouselMovies = Movie::latest()->take(5)->get();
        $featuredMovie = $carouselMovies->first();

        // Topics / chips
        $topGenres = Genre::orderBy('genre_name')->take(7)->get();

        // Fetch categories & country to dynamically find their IDs (support EN + VI names)
        $movieCat = Category::where(function($q){
                $q->where('cat_name','like','%movie%')
                  ->orWhere('cat_name','like','%phim lẻ%')
                  ->orWhere('cat_name','like','%phim le%');
            })->first();
        $tvSeriesCat = Category::where(function($q){
                $q->where('cat_name','like','%series%')
                  ->orWhere('cat_name','like','%tv%')
                  ->orWhere('cat_name','like','%phim bộ%')
                  ->orWhere('cat_name','like','%phim bo%');
            })->first();
        $korea = Country::where('country_name', 'like', '%korea%')->first();

        $topMovies = $movieCat ? Movie::where('cat_id', $movieCat->cat_id)->latest()->take(10)->get() : collect();
        $topTvSeries = $tvSeriesCat ? Movie::where('cat_id', $tvSeriesCat->cat_id)->latest()->take(10)->get() : collect();
        $topKoreanTvSeries = ($tvSeriesCat && $korea)
            ? Movie::where('cat_id', $tvSeriesCat->cat_id)->where('country_id', $korea->country_id)->latest()->take(10)->get()
            : collect();

        // Latest Anime list for spotlight
        $animeGenre = Genre::where('genre_name', 'like', '%anime%')->first();
        $latestAnime = $animeGenre ? Movie::where('genre_id', $animeGenre->genre_id)->latest()->take(12)->get() : collect();

        // Theatrical highlights (latest single movies)
        $theatricalHighlights = $movieCat ? Movie::where('cat_id', $movieCat->cat_id)->orderBy('created_at','desc')->take(8)->get() : collect();

        // Top 10 today by view count (safe if table not existing)
        $topToday = collect();
        try {
            $startDay = now()->startOfDay();
            $endDay = now()->endOfDay();
            $topMoviesToday = \DB::table('movie_views')
                ->select('movie_id', \DB::raw('COUNT(*) as views'))
                ->whereBetween('created_at', [$startDay, $endDay])
                ->groupBy('movie_id')
                ->orderByDesc('views')
                ->limit(10)
                ->get();
            $topTodayIds = $topMoviesToday->pluck('movie_id')->all();
            $topTodayModels = Movie::whereIn('movie_id', $topTodayIds)->get()->keyBy('movie_id');
            $topToday = $topMoviesToday->map(function ($row) use ($topTodayModels) {
                $m = $topTodayModels->get($row->movie_id);
                return $m ? (object) ['movie' => $m, 'views' => $row->views] : null;
            })->filter()->values();
        } catch (\Throwable $e) {
            $topToday = collect();
        }

        // Latest Japan releases
        $japan = Country::where('country_name', 'like', '%japan%')->first();
        $latestJapan = $japan ? Movie::where('country_id', $japan->country_id)->latest()->take(12)->get() : collect();

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
            'featuredMovie',
            'topGenres',
            'latestAnime',
            'theatricalHighlights',
            'topToday',
            'latestJapan',
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
    public function watchMovie(Movie $movie)
    {
        // You might want to get related movies or episodes here as well
        $related = Movie::where('cat_id', $movie->cat_id)
            ->where('movie_id', '!=', $movie->movie_id)
            ->latest()
            ->take(10)
            ->get();

        return view('pages.watch-movie', compact('movie', 'related'));
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
        if ($request->filled('genre')) {
            $query->where('genre_id', (int) $request->input('genre'));
        }
        if ($request->filled('year')) {
            $query->where('release_year', (int) $request->input('year'));
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
        $genres = \App\Models\Genre::orderBy('genre_name')->get(['genre_id','genre_name']);

        return view('pages.movie', compact('movies', 'categories', 'countries', 'genres'));
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
        $genres = Genre::orderBy('genre_name')->get(['genre_id','genre_name']);

        return view('pages.movie', compact('movies', 'categories', 'countries','genres'));
    }

    // Genres index page
    public function genresIndex()
    {
        $genres = Genre::orderBy('genre_name')->get();
        return view('pages.genres-index', compact('genres'));
    }

    // Movies by genre
    public function genreShow(Genre $genre, Request $request)
    {
        $query = Movie::where('genre_id', $genre->genre_id);
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
        $genres = Genre::orderBy('genre_name')->get(['genre_id','genre_name']);
        return view('pages.movie', compact('movies','categories','countries','genres'));
    }

    // User profile page
    public function profile()
    {
        return view('pages.profile');
    }

    // My List page: favorites + playlists (requires auth)
    public function favorites()
    {
        $user = Auth::user();
        $movies = $user ? $user->favorites()->latest()->paginate(12) : collect();
        $playlists = $user ? $user->playlists()->with(['movies' => function($q){ $q->latest(); }])->withCount('movies')->get() : collect();
        return view('pages.favorites', compact('movies', 'playlists'));
    }

    // Suggest movies for search overlay (JSON)
    public function searchSuggestions(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $limit = (int) ($request->get('limit', 18));
        $limit = max(6, min(48, $limit));

        if ($q !== '') {
            $movies = Movie::where('movie_name', 'like', "%{$q}%")
                ->orderBy('created_at','desc')
                ->limit($limit)
                ->get(['movie_id','movie_name','image']);
        } else {
            // Popular this month by views (fallback to latest)
            try {
                $startMonth = now()->startOfMonth();
                $endMonth = now()->endOfMonth();
                $popular = \DB::table('movie_views')
                    ->select('movie_id', \DB::raw('COUNT(*) as views'))
                    ->whereBetween('created_at', [$startMonth, $endMonth])
                    ->groupBy('movie_id')
                    ->orderByDesc('views')
                    ->limit($limit)
                    ->get();
                $ids = $popular->pluck('movie_id')->all();
                $movies = Movie::whereIn('movie_id', $ids)
                    ->get(['movie_id','movie_name','image']);
                // Keep the order as by views
                $byId = $movies->keyBy('movie_id');
                $movies = $popular->map(fn($r) => $byId->get($r->movie_id))->filter()->values();
                if ($movies->isEmpty()) {
                    $movies = Movie::latest()->limit($limit)->get(['movie_id','movie_name','image']);
                }
            } catch (\Throwable $e) {
                $movies = Movie::latest()->limit($limit)->get(['movie_id','movie_name','image']);
            }
        }

        $data = $movies->map(function ($m) {
            return [
                'id' => $m->movie_id,
                'title' => $m->movie_name,
                'image' => asset('img/'.$m->image),
                'url' => route('movies.show', $m->movie_id),
            ];
        });

        return response()->json(['items' => $data]);
    }
}
