@extends('layout')
@section('content')

<div class="container" style="margin-top:20px;color:#fff;">
    <div class="d-flex" style="align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;">
        <h2 style="margin:0;">Playlist: {{ $playlist->name }}</h2>
        <a href="{{ route('favorites') }}" class="btn btn-sm btn-outline-light">Trở lại My List</a>
    </div>

    <div class="movie-list" style="margin-top:16px;">
        <div class="d-flex" style="flex-wrap:wrap;">
            @forelse ($movies as $movie)
                <div class="movie-info col-3">
                    <img src="{{ asset('img/' . $movie->image) }}" alt="{{ $movie->movie_name }}">
                    <div class="movie-name">
                        <h2>{{ $movie->movie_name }}</h2>
                    </div>
                    <div class="movie-feature d-flex">
                        <a class="btn btn-md btn-light" href="{{ route('movies.show', $movie->movie_id) }}">Watch <i class="fas fa-play"></i></a>
                        {{-- TODO: Add remove from playlist button --}}
                    </div>
                </div>
            @empty
                <p>Playlist này chưa có phim nào.</p>
            @endforelse
        </div>

        <div class="d-flex" style="justify-content:center;margin-top:20px;">
            {{ $movies->links() }}
        </div>
    </div>
</div>

@endsection
