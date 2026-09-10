<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
    // Home page
    public function home()
    {
        // Cache public blocks for short TTLs to improve performance
        $carouselMovies = Cache::remember('home:carousel', 120, fn()=> Movie::orderByDesc('created_at')->limit(5)->get());
        $featuredMovie = $carouselMovies->first();

        // Topics / chips
        $topGenres = Cache::remember('home:top-genres', 300, fn()=> Genre::orderBy('genre_name')->limit(7)->get());

        // Fetch categories & country to dynamically find their IDs (support EN + VI names)
        $movieCat = Cache::remember('home:cat-movie', 600, function(){
            return Category::where(function($q){
                $q->where('cat_name','like','%movie%')
                  ->orWhere('cat_name','like','%phim lẻ%')
                  ->orWhere('cat_name','like','%phim le%');
            })->first();
        });
        $tvSeriesCat = Cache::remember('home:cat-series', 600, function(){
            return Category::where(function($q){
                $q->where('cat_name','like','%series%')
                  ->orWhere('cat_name','like','%tv%')
                  ->orWhere('cat_name','like','%phim bộ%')
                  ->orWhere('cat_name','like','%phim bo%');
            })->first();
        });
        $korea = Cache::remember('home:country-korea', 600, fn()=> Country::where('country_name', 'like', '%korea%')->first());

        $topMovies = $movieCat ? Cache::remember("home:top-movies:{$movieCat->cat_id}", 180, fn()=> Movie::where('cat_id', $movieCat->cat_id)->orderByDesc('created_at')->limit(10)->get()) : collect();
        $topTvSeries = $tvSeriesCat ? Cache::remember("home:top-series:{$tvSeriesCat->cat_id}", 180, fn()=> Movie::where('cat_id', $tvSeriesCat->cat_id)->orderByDesc('created_at')->limit(10)->get()) : collect();
        $topKoreanTvSeries = ($tvSeriesCat && $korea)
            ? Cache::remember("home:top-korean-series:{$tvSeriesCat->cat_id}:{$korea->country_id}", 180, fn() => Movie::where('cat_id', $tvSeriesCat->cat_id)->where('country_id', $korea->country_id)->orderByDesc('created_at')->limit(10)->get())
            : collect();

        // Latest Anime list for spotlight
        $animeGenre = Cache::remember('home:genre-anime', 600, fn()=> Genre::where('genre_name', 'like', '%anime%')->first());
        $latestAnime = $animeGenre ? Cache::remember("home:latest-anime:{$animeGenre->genre_id}", 180, fn()=> Movie::where('genre_id', $animeGenre->genre_id)->orderByDesc('created_at')->limit(12)->get()) : collect();

        // Theatrical highlights (latest single movies)
        $theatricalHighlights = $movieCat ? Cache::remember("home:theatrical:{$movieCat->cat_id}", 180, fn()=> Movie::where('cat_id', $movieCat->cat_id)->orderBy('created_at','desc')->limit(8)->get()) : collect();

        // Top 10 today by view count (safe if table not existing)
        $topToday = collect();
        try {
            $startDay = now()->startOfDay();
            $endDay = now()->endOfDay();
            $topMoviesToday = Cache::remember("home:top-today:{$startDay->timestamp}", 60, function() use ($startDay, $endDay){
                return \DB::table('movie_views')
                    ->select('movie_id', \DB::raw('COUNT(*) as views'))
                    ->whereBetween('created_at', [$startDay, $endDay])
                    ->groupBy('movie_id')
                    ->orderByDesc('views')
                    ->limit(10)
                    ->get();
            });
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
        $japan = Cache::remember('home:country-japan', 600, fn()=> Country::where('country_name', 'like', '%japan%')->first());
        $latestJapan = $japan ? Cache::remember("home:latest-japan:{$japan->country_id}", 180, fn()=> Movie::where('country_id', $japan->country_id)->orderByDesc('created_at')->limit(12)->get()) : collect();

        // Coming soon: only 5
        $comingSoonMovies = Cache::remember('home:coming-soon', 180, fn()=> Movie::where('status', 0)->orderByDesc('created_at')->limit(5)->get());

        // Top movies this month by view count (movie_views table)
        $startMonth = now()->startOfMonth();
        $endMonth = now()->endOfMonth();
        $topMoviesThisMonth = Cache::remember("home:top-month:{$startMonth->format('Y-m')}", 300, function() use ($startMonth, $endMonth){
            return \DB::table('movie_views')
                ->select('movie_id', \DB::raw('COUNT(*) as views'))
                ->whereBetween('created_at', [$startMonth, $endMonth])
                ->groupBy('movie_id')
                ->orderByDesc('views')
                ->limit(5)
                ->get();
        });
        $topMovieIds = $topMoviesThisMonth->pluck('movie_id')->all();
        $topMoviesMonthModels = Movie::whereIn('movie_id', $topMovieIds)->get()->keyBy('movie_id');
        $topMoviesThisMonth = $topMoviesThisMonth->map(function ($row) use ($topMoviesMonthModels) {
            $m = $topMoviesMonthModels->get($row->movie_id);
            return $m ? (object) ['movie' => $m, 'views' => $row->views] : null;
        })->filter();

        $playlists = Auth::check() ? Auth::user()->playlists : collect();

        // Continue watching (per-user, no cache)
        $continueWatching = collect();
        $recommended = collect();
        if (Auth::check()) {
            $progressRows = \App\Models\UserProgress::where('user_id', Auth::id())
                ->orderByDesc('last_seen_at')
                ->limit(50)
                ->get(['movie_id','episode_id','position_seconds','duration_seconds','last_seen_at']);
            $movieIds = $progressRows->pluck('movie_id')->unique()->values();
            $moviesById = Movie::whereIn('movie_id', $movieIds)->get()->keyBy('movie_id');
            $continueWatching = $progressRows->map(function($r) use ($moviesById){
                $m = $moviesById->get($r->movie_id);
                if (!$m) return null;
                return (object) [
                    'movie' => $m,
                    'episode_id' => $r->episode_id,
                    'position' => (int)$r->position_seconds,
                    'duration' => (int)($r->duration_seconds ?? 0),
                    'last_seen_at' => $r->last_seen_at,
                ];
            })->filter()->values();

            // Basic recommendations: top genres/countries from favorites + history
            $fav = Auth::user()->favorites()->get(['tbl_movie.movie_id','tbl_movie.genre_id','tbl_movie.country_id']);
            $historyMovies = $moviesById->values();
            $genreCounts = collect();
            $countryCounts = collect();
            foreach ($fav as $m) { $genreCounts[$m->genre_id ?? 0] = ($genreCounts[$m->genre_id ?? 0] ?? 0) + 2; $countryCounts[$m->country_id ?? 0] = ($countryCounts[$m->country_id ?? 0] ?? 0) + 2; }
            foreach ($historyMovies as $m) { $genreCounts[$m->genre_id ?? 0] = ($genreCounts[$m->genre_id ?? 0] ?? 0) + 1; $countryCounts[$m->country_id ?? 0] = ($countryCounts[$m->country_id ?? 0] ?? 0) + 1; }
            $topGenresIds = collect($genreCounts)->sortDesc()->keys()->take(3)->filter()->values();
            $topCountriesIds = collect($countryCounts)->sortDesc()->keys()->take(3)->filter()->values();

            // Unfinished movies prioritization (< 90% watched)
            $unfinishedIds = $progressRows->filter(function($r){
                $dur = (int)($r->duration_seconds ?? 0);
                $pos = (int)($r->position_seconds ?? 0);
                return $dur > 0 && $pos < max(1, $dur) * 0.9;
            })->pluck('movie_id')->unique()->values();
            $unfinished = Movie::whereIn('movie_id', $unfinishedIds)->orderByDesc('created_at')->get();

            $excludeIds = $movieIds->merge($fav->pluck('movie_id'))->unique()->values();
            $pool = collect();
            if ($topGenresIds->isNotEmpty() || $topCountriesIds->isNotEmpty()) {
                $pool = Movie::query()
                    ->where(function($q) use ($topGenresIds, $topCountriesIds){
                        $first = true;
                        if ($topGenresIds->isNotEmpty()) { $q->whereIn('genre_id', $topGenresIds); $first = false; }
                        if ($topCountriesIds->isNotEmpty()) { $first ? $q->whereIn('country_id', $topCountriesIds) : $q->orWhereIn('country_id', $topCountriesIds); }
                    })
                    ->whereNotIn('movie_id', $excludeIds)
                    ->orderByDesc('created_at')
                    ->limit(80)
                    ->get();
            }

            // Interleave by genre, with unfinished placed first
            $byGenre = $pool->groupBy('genre_id');
            $roundRobin = collect();
            $maxLen = $byGenre->max(fn($c)=> $c->count()) ?? 0;
            for ($i=0; $i<$maxLen; $i++) {
                foreach ($byGenre as $gid => $items) {
                    $item = $items->get($i);
                    if ($item) $roundRobin->push($item);
                }
            }
            // Remove any duplicates and cut to limit
            $unfinishedMap = $unfinished->keyBy('movie_id');
            $recommended = $unfinished->concat($roundRobin)->unique('movie_id')->take(12)->values();
        }

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
            'playlists',
            'continueWatching',
            'recommended'
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

        // Calculate average rating
        $averageRating = $movie->ratings()->avg('rating');
        $ratingCount = $movie->ratings()->count();
        $userRating = Auth::check() ? $movie->ratings()->where('user_id', Auth::id())->first() : null;

        return view('pages.movie-detail', compact('movie', 'related', 'playlists', 'averageRating', 'ratingCount', 'userRating'));
    }

    // Watch movie page
    public function watchMovie(Request $request, Movie $movie)
    {
        // Episodes list for this movie
        $episodes = \App\Models\Episode::where('movie_id', $movie->movie_id)
            ->orderBy('eps_num')
            ->get();

        // Determine current episode by query ?ep=eps_id or default first
        $currentEpisode = null;
        if ($episodes->count()) {
            $currentEpisode = $episodes->firstWhere('eps_id', (int)$request->query('ep')) ?: $episodes->first();
        }

        // Determine resume position for current user
        $resumeSeconds = 0;
        if (\Illuminate\Support\Facades\Auth::check()) {
            $resume = \App\Models\UserProgress::where('user_id', \Illuminate\Support\Facades\Auth::id())
                ->where('movie_id', $movie->movie_id)
                ->where('episode_id', $currentEpisode?->eps_id)
                ->first();
            $resumeSeconds = (int) ($resume->position_seconds ?? 0);
        }

        // Player decision & subtitles
        $playerType = 'youtube';
        $videoSrc = null;
        $embedUrl = 'https://www.youtube.com/watch?v=z50hkrXG50I';
        $link = $currentEpisode->link ?? '';
        if ($link) {
            $isYouTube = (bool) preg_match('~(?:youtu\\.be/|youtube\\.com/(?:watch\\?v=|embed/))([\\w-]{6,})~i', $link);
            $isIdOnly = (bool) preg_match('~^[\\w-]{6,}$~', $link);
            $isHls = str_ends_with(strtolower($link), '.m3u8');
            $isMp4 = str_ends_with(strtolower($link), '.mp4');
            if ($isHls || $isMp4) {
                $playerType = 'html5';
                $videoSrc = $link;
            } elseif ($isYouTube || $isIdOnly) {
                $playerType = 'youtube';
                if ($isYouTube) {
                    if (preg_match('~(?:youtu\\.be/|youtube\\.com/(?:watch\\?v=|embed/))([\\w-]{6,})~i', $link, $m)) {
                        $vid = $m[1];
                        $embedUrl = "https://www.youtube.com/embed/{$vid}?enablejsapi=1&autoplay=1";
                    }
                } else {
                    $embedUrl = "https://www.youtube.com/embed/{$link}?enablejsapi=1&autoplay=1";
                }
            } else {
                // Fallback to treat as direct link
                $playerType = 'html5';
                $videoSrc = $link;
            }
        }
        if ($playerType === 'youtube' && $resumeSeconds > 0) {
            $embedUrl .= (str_contains($embedUrl,'?') ? '&' : '?') . 'start=' . $resumeSeconds;
        }

        // Load subtitles (episode-specific first, then movie-level)
        $subtitles = \App\Models\Subtitle::where(function($q) use ($movie, $currentEpisode){
                $q->where(function($q2) use ($movie, $currentEpisode){ $q2->where('movie_id', $movie->movie_id)->whereNull('episode_id'); });
                if ($currentEpisode) { $q->orWhere(function($q3) use ($currentEpisode){ $q3->where('episode_id', $currentEpisode->eps_id); }); }
            })
            ->orderByDesc('is_default')
            ->get();

        // Related movies
        $related = Movie::where('cat_id', $movie->cat_id)
            ->where('movie_id', '!=', $movie->movie_id)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // Next/Prev episode
        $nextEpisode = $prevEpisode = null;
        if ($currentEpisode) {
            $idx = $episodes->search(fn($e)=> $e->eps_id === $currentEpisode->eps_id);
            if ($idx !== false) {
                $prevEpisode = $episodes->get($idx - 1);
                $nextEpisode = $episodes->get($idx + 1);
            }
        }

        return view('pages.watch-movie', compact('movie', 'related', 'episodes', 'currentEpisode', 'nextEpisode', 'prevEpisode', 'embedUrl', 'playerType', 'videoSrc', 'subtitles', 'resumeSeconds'));
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
            case 'views':
                $query->withCount('views')->orderByDesc('views_count');
                break;
            case 'rating':
                $query->withAvg('ratings', 'rating')->orderByDesc('ratings_avg_rating');
                break;
            default: // latest
                $query->orderByDesc('created_at');
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

    // Full search results page
    public function search(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $query = Movie::query();

        if ($q !== '') {
            $query->where(function ($query) use ($q) {
                $query->where('movie_name', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%");
            });
        }

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

        switch ($request->get('sort')) {
            case 'views':
                $query->withCount('views')->orderByDesc('views_count');
                break;
            case 'rating':
                $query->withAvg('ratings', 'rating')->orderByDesc('ratings_avg_rating');
                break;
            default: // latest
                $query->orderByDesc('created_at');
        }

        $movies = $query->paginate(12)->appends($request->query());

        $categories = Category::orderBy('cat_name')->get(['cat_id', 'cat_name']);
        $countries = Country::orderBy('country_name')->get(['country_id', 'country_name']);
        $genres = Genre::orderBy('genre_name')->get(['genre_id','genre_name']);

        return view('pages.search-results', compact('movies', 'q', 'categories', 'countries', 'genres'));
    }



}

