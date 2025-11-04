@extends('layout')
@section('content')

<div class="container" style="margin-top:20px; color:#fff;">
    <div class="d-flex" style="align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;">
        <h2 style="margin:0;">Tất cả phim</h2>
        <form method="GET" class="d-flex" style="gap:8px; flex-wrap:wrap; align-items:center;">
            <select name="category" class="form-control" style="max-width:180px;">
                <option value="">-- Thể loại --</option>
                @isset($categories)
                @foreach($categories as $c)
                    <option value="{{ $c->cat_id }}" {{ request('category')==$c->cat_id ? 'selected' : '' }}>{{ $c->cat_name }}</option>
                @endforeach
                @endisset
            </select>
            <select name="country" class="form-control" style="max-width:180px;">
                <option value="">-- Quốc gia --</option>
                @isset($countries)
                @foreach($countries as $c)
                    <option value="{{ $c->country_id }}" {{ request('country')==$c->country_id ? 'selected' : '' }}>{{ $c->country_name }}</option>
                @endforeach
                @endisset
            </select>
            <select name="status" class="form-control" style="max-width:140px;">
                <option value="">-- Trạng thái --</option>
                <option value="1" {{ request('status')==='1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ request('status')==='0' ? 'selected' : '' }}>Inactive</option>
            </select>
            <select name="sort" class="form-control" style="max-width:180px;">
                <option value="created_desc" {{ request('sort')=='created_desc' ? 'selected' : '' }}>Mới nhất</option>
                <option value="created_asc" {{ request('sort')=='created_asc' ? 'selected' : '' }}>Cũ nhất</option>
                <option value="name_asc" {{ request('sort')=='name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                <option value="name_desc" {{ request('sort')=='name_desc' ? 'selected' : '' }}>Tên Z-A</option>
            </select>
            <button class="btn btn-sm btn-outline-light" type="submit">Lọc</button>
            <a class="btn btn-sm btn-dark" href="{{ route('movies.index') }}">Đặt lại</a>
        </form>
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
                        @auth
                        <form method="POST" action="{{ route('favorites.toggle', $movie->movie_id) }}">
                            @csrf
                            <button class="btn btn-md btn-danger" type="submit">
                                @if(auth()->user()->favorites->contains($movie->movie_id))
                                    <i class="fas fa-heart"></i>
                                @else
                                    <i class="far fa-heart"></i>
                                @endif
                            </button>
                        </form>
                        @endauth
                    </div>
                </div>
            @empty
                <p>Chưa có phim nào.</p>
            @endforelse
        </div>

        <div class="d-flex" style="justify-content:center;margin-top:20px;">
            {{ $movies->links() }}
        </div>
    </div>
</div>

@endsection
