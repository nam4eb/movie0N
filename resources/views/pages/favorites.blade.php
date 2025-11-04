@extends('layout')
@section('content')

<div class="container" style="margin-top:20px;color:#fff;">
    <div class="d-flex" style="align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;">
        <h2 style="margin:0;">Danh sách phim yêu thích</h2>
        <a href="{{ route('movies.index') }}" class="btn btn-sm btn-outline-light">Xem tất cả phim</a>
    </div>

    <div class="movie-list" style="margin-top:16px;">
        <div class="d-flex" style="flex-wrap:wrap;">
            @auth
                @forelse ($movies as $movie)
                    <div class="movie-info col-3">
                        <img src="{{ asset('img/' . $movie->image) }}" alt="{{ $movie->movie_name }}">
                        <div class="movie-name">
                            <h2>{{ $movie->movie_name }}</h2>
                        </div>
                        <div class="movie-feature d-flex">
                            <a class="btn btn-md btn-light" href="{{ route('movies.show', $movie->movie_id) }}">Watch <i class="fas fa-play"></i></a>
                            <form method="POST" action="{{ route('favorites.toggle', $movie->movie_id) }}">
                                @csrf
                                <button class="btn btn-md btn-danger" type="submit"><i class="fas fa-heart"></i></button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p>Bạn chưa có phim yêu thích nào.</p>
                @endforelse
            @else
                <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để xem danh sách yêu thích.</p>
            @endauth
        </div>

        @auth
            <div class="d-flex" style="justify-content:center;margin-top:20px;">
                {{ $movies->links() }}
            </div>
        @endauth
    </div>
</div>

@endsection

