@extends('layout')
@section('content')

<div class="container" style="margin-top:20px;color:#fff;">
    <div class="d-flex" style="align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;">
        <h2 style="margin:0;">My List</h2>
        <a href="{{ route('movies.index') }}" class="btn btn-sm btn-outline-light">Xem tất cả phim</a>
    </div>

    {{-- Favorites section --}}
    <div class="movie-list" style="margin-top:16px;">
        <h4 style="margin:0 0 10px 0;">Yêu thích</h4>
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
                            <form method="POST" action="{{ route('favorites.toggle', $movie->movie_id) }}" class="favorite-toggle-form" data-movie-id="{{ $movie->movie_id }}">
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

    {{-- Playlists section --}}
    @auth
    <div style="margin-top:30px;">
        <div class="d-flex" style="align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;">
            <h4 style="margin:0;">Playlists của bạn</h4>
            <form action="{{ route('playlists.store') }}" method="POST" class="form-inline">
                @csrf
                <input type="text" name="name" class="form-control form-control-sm mr-2" placeholder="Tên playlist" required style="background:#222;color:#fff;border-color:#444;">
                <button class="btn btn-sm btn-primary" type="submit">Tạo playlist</button>
            </form>
        </div>

        <div class="row" style="margin-top:12px;">
            @forelse($playlists as $pl)
                <div class="col-md-4" style="margin-bottom:16px;">
                    <div class="card" style="background:#0c0e12;border-radius:12px;padding:12px;">
                        <div class="d-flex" style="align-items:center; justify-content:space-between;">
                            <div>
                                <h5 style="margin:0;">{{ $pl->name }}</h5>
                                <small>{{ $pl->movies_count ?? ($pl->movies->count() ?? 0) }} phim</small>
                            </div>
                            <a href="{{ url('/playlists/'.$pl->id) }}" class="btn btn-sm btn-outline-light">Xem</a>
                        </div>
                        <div class="d-flex" style="gap:6px; margin-top:10px; flex-wrap:wrap;">
                            @php($thumbs = ($pl->relationLoaded('movies') ? $pl->movies : $pl->movies()->latest()->take(4)->get()))
                            @forelse($thumbs as $m)
                                <img src="{{ asset('img/' . $m->image) }}" alt="{{ $m->movie_name }}" style="width:22%;border-radius:6px;object-fit:cover;">
                            @empty
                                <div class="text-muted">Chưa có phim</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @empty
                <p>Bạn chưa có playlist nào.</p>
            @endforelse
        </div>
    </div>
    @endauth
</div>

@endsection
