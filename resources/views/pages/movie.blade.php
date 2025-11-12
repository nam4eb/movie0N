@extends('layout')
@section('content')

<div class="container movie-listing-page">
    <form method="GET" class="filter-bar">
        <div class="filter-group">
            <div class="filter-item">
                <select name="sort" class="form-control custom-select filter-select">
                    <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>{{ __('messages.sort_by_latest') }}</option>
                    <option value="views" {{ request('sort') == 'views' ? 'selected' : '' }}>{{ __('messages.sort_by_views') }}</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>{{ __('messages.sort_by_rating') }}</option>
                </select>
            </div>
            <div class="filter-item">
                <select name="genre" class="form-control custom-select filter-select">
                    <option value="">{{ __('messages.all_genres') }}</option>
                    @foreach($genres as $g)
                        <option value="{{ $g->genre_id }}" {{ request()->query('genre')==$g->genre_id ? 'selected' : '' }}>{{ $g->genre_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-item">
                <select name="country" class="form-control custom-select filter-select">
                    <option value="">{{ __('messages.all_countries') }}</option>
                     @foreach($countries as $c)
                        <option value="{{ $c->country_id }}" {{ request()->query('country')==$c->country_id ? 'selected' : '' }}>{{ $c->country_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-item">
                 <select name="category" class="form-control custom-select filter-select">
                    <option value="">{{ __('messages.all_categories') }}</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->cat_id }}" {{ request()->query('category')==$c->cat_id ? 'selected' : '' }}>{{ $c->cat_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-item">
                <select name="year" class="form-control custom-select filter-select">
                    <option value="">{{ __('messages.production_year') }}</option>
                    @for($y = now()->year; $y >= 1980; $y--)
                        <option value="{{ $y }}" {{ (string)request()->query('year')===(string)$y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="filter-actions" style="display:none;">
            <button class="btn btn-primary" type="submit">{{ __('messages.filter_movies') }}</button>
            <a class="btn btn-secondary" href="{{ route('movies.index') }}">{{ __('messages.reset') }}</a>
        </div>
    </form>

    @php($userPlaylists = auth()->check() ? auth()->user()->playlists : collect())
    <div class="movie-grid">
        @forelse ($movies as $movie)
            <div class="movie-card-v2">
                <div class="card-img">
                    <a href="{{ route('movies.show', $movie->movie_id) }}">
                        <img src="{{ asset('img/' . $movie->image) }}" alt="{{ $movie->movie_name }}">
                    </a>
                    <div class="card-overlay">
                        <a href="{{ route('movie.watch', $movie->movie_id) }}" class="btn-play"><i class="fas fa-play"></i></a>
                        @auth
                            <form method="POST" action="{{ route('favorites.toggle', $movie->movie_id) }}" class="d-inline favorite-toggle-form" data-movie-id="{{ $movie->movie_id }}">
                                @csrf
                                <button class="btn-favorite" type="submit">
                                    @if(auth()->user()->favorites()->wherePivot('movie_id', $movie->movie_id)->exists())
                                        <i class="fas fa-heart"></i>
                                    @else
                                        <i class="far fa-heart"></i>
                                    @endif
                                </button>
                            </form>
                            {{-- Add to playlist dropdown --}}
                            <div class="dropdown d-inline">
                                <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" id="dd-{{ $movie->movie_id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-{{ $movie->movie_id }}">
                                    @forelse($userPlaylists as $pl)
                                        <form method="POST" action="{{ route('playlists.movies.add', [$pl->id, $movie->movie_id]) }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">{{ $pl->name }}</button>
                                        </form>
                                    @empty
                                        <a class="dropdown-item" href="{{ route('playlists.index') }}">Tạo playlist mới…</a>
                                    @endforelse
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><a href="{{ route('movies.show', $movie->movie_id) }}">{{ $movie->movie_name }}</a></h5>
                </div>

                <!-- Hover Expand Panel -->
                <div class="hover-panel">
                    <div class="hp-backdrop" style="background-image:url('{{ asset('img/' . $movie->image) }}')"></div>
                    <div class="hp-content">
                        <div class="hp-head">
                            <div class="hp-title">{{ $movie->movie_name }}</div>
                            <div class="hp-sub">@if($movie->category){{ $movie->category->cat_name }}@endif</div>
                        </div>
                        <div class="hp-actions">
                            <a href="{{ route('movie.watch', $movie->movie_id) }}" class="btn btn-primary btn-sm"><i class="fas fa-play"></i> Xem ngay</a>
                            @auth
                                <form method="POST" action="{{ route('favorites.toggle', $movie->movie_id) }}" class="d-inline favorite-toggle-form" data-movie-id="{{ $movie->movie_id }}">
                                    @csrf
                                    <button class="btn btn-outline-light btn-sm" type="submit"><i class="far fa-heart"></i> Thích</button>
                                </form>
                            @endauth
                            <a href="{{ route('movies.show', $movie->movie_id) }}" class="btn btn-outline-light btn-sm">Chi tiết</a>
                        </div>
                        <div class="hp-tags">
                            @if($movie->genre)
                                <span class="tag">{{ $movie->genre->genre_name }}</span>
                            @endif
                            @if($movie->country)
                                <span class="tag">{{ $movie->country->country_name }}</span>
                            @endif
                            @if($movie->category)
                                <span class="tag">{{ $movie->category->cat_name }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /Hover Expand Panel -->
            </div>
        @empty
            <div class="no-results">
                <p>{{ __('messages.no_movies_found') }}</p>
            </div>
        @endforelse
    </div>

    <div class="pagination-wrapper">
        {{ $movies->links('vendor.pagination.custom') }}
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('.filter-bar');
            if (!form) return;
            const selects = form.querySelectorAll('.filter-select');
            selects.forEach(function (sel) {
                sel.addEventListener('change', function () {
                    const pageInput = form.querySelector('input[name="page"]');
                    if (pageInput) pageInput.remove();
                    if (form.requestSubmit) form.requestSubmit(); else form.submit();
                });
            });
        });
    </script>
</div>

@endsection
