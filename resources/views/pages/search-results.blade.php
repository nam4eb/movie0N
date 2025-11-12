@extends('layout')
@section('content')

<div class="container movie-listing-page">
    <h2 class="my-4">{{ __('messages.search_results') }} @if($q)<small class="text-muted">({{ $movies->total() }} {{ __('messages.results_for') }} "{{ $q }}")</small>@endif</h2>

    <form method="GET" class="filter-bar">
        <div class="filter-group">
            <div class="filter-item" style="flex-grow:1;">
                <input type="search" name="q" class="form-control" placeholder="{{ __('messages.search') }}" value="{{ $q ?? '' }}">
            </div>
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
                <select name="year" class="form-control custom-select filter-select">
                    <option value="">{{ __('messages.production_year') }}</option>
                    @for($y = now()->year; $y >= 1980; $y--)
                        <option value="{{ $y }}" {{ (string)request()->query('year')===(string)$y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </form>

    @php($userPlaylists = auth()->check() ? auth()->user()->playlists : collect())
    <div class="movie-grid mt-4">
        @forelse ($movies as $movie)
            @include('components.movie-card-v2', ['movie' => $movie, 'userPlaylists' => $userPlaylists])
        @empty
            <div class="no-results">
                <p>{{ __('messages.no_movies_found') }}</p>
            </div>
        @endforelse
    </div>

    <div class="pagination-wrapper">
        {{ $movies->links('vendor.pagination.custom') }}
    </div>
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

@endsection

