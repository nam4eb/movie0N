@extends('layout')
@section('content')

<div class="container movie-listing-page">
    <form method="GET" class="filter-bar">
        <div class="filter-group">
            <div class="filter-item">
                <select name="sort" class="form-control custom-select filter-select">
                    <option value="created_desc" {{ request('sort')=='created_desc' ? 'selected' : '' }}>Sắp xếp: Mới nhất</option>
                    <option value="created_asc" {{ request('sort')=='created_asc' ? 'selected' : '' }}>Sắp xếp: Cũ nhất</option>
                    <option value="name_asc" {{ request('sort')=='name_asc' ? 'selected' : '' }}>Sắp xếp: Tên A-Z</option>
                    <option value="name_desc" {{ request('sort')=='name_desc' ? 'selected' : '' }}>Sắp xếp: Tên Z-A</option>
                </select>
            </div>
            <div class="filter-item">
                <select name="genre" class="form-control custom-select filter-select">
                    <option value="">Tất cả thể loại</option>
                    @foreach($genres as $g)
                        <option value="{{ $g->genre_id }}" {{ request()->query('genre')==$g->genre_id ? 'selected' : '' }}>{{ $g->genre_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-item">
                <select name="country" class="form-control custom-select filter-select">
                    <option value="">Tất cả quốc gia</option>
                     @foreach($countries as $c)
                        <option value="{{ $c->country_id }}" {{ request()->query('country')==$c->country_id ? 'selected' : '' }}>{{ $c->country_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-item">
                 <select name="category" class="form-control custom-select filter-select">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->cat_id }}" {{ request()->query('category')==$c->cat_id ? 'selected' : '' }}>{{ $c->cat_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="filter-actions" style="display:none;">
            <button class="btn btn-primary" type="submit">Lọc phim</button>
            <a class="btn btn-secondary" href="{{ route('movies.index') }}">Đặt lại</a>
        </div>
    </form>

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
                            <form method="POST" action="{{ route('favorites.toggle', $movie->movie_id) }}" class="d-inline">
                                @csrf
                                <button class="btn-favorite" type="submit">
                                    @if(auth()->user()->favorites()->where('movie_id', $movie->movie_id)->exists())
                                        <i class="fas fa-heart"></i>
                                    @else
                                        <i class="far fa-heart"></i>
                                    @endif
                                </button>
                            </form>
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
                                <form method="POST" action="{{ route('favorites.toggle', $movie->movie_id) }}" class="d-inline">
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
                <p>Không tìm thấy phim nào phù hợp.</p>
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
