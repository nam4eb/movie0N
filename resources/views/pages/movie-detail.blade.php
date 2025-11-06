@extends('layout')
@section('content')

<div class="movie-detail-page theme-orange">
    {{-- Hero section with backdrop --}}
    <div class="movie-detail-hero">
        <div class="backdrop-img" style="background-image: url('{{ asset('img/' . $movie->image) }}')"></div>
        <div class="hero-content">
            <div class="container">
                <div class="hero-main">
                    <div class="poster">
                        <img src="{{ asset('img/' . $movie->image) }}" alt="{{ $movie->movie_name }}">
                    </div>
                    <div class="info">
                        <h1 class="movie-title">{{ $movie->movie_name }}</h1>
                        <div class="meta">The Mandalorian</div>
                        <div class="actions">
                            <a href="{{ route('movie.watch', $movie->movie_id) }}" class="btn btn-primary btn-lg"><i class="fas fa-play"></i> Xem Ngay</a>
                            @auth
                                <form method="POST" action="{{ route('favorites.toggle', $movie->movie_id) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-icon" type="submit" title="Yêu thích">
                                        @if(auth()->user()->favorites()->where('movie_id', $movie->movie_id)->exists())
                                            <i class="fas fa-heart"></i>
                                        @else
                                            <i class="far fa-heart"></i>
                                        @endif
                                    </button>
                                </form>
                            @endauth
                            <button class="btn btn-icon" title="Chia sẻ"><i class="fas fa-share-alt"></i></button>
                            <button class="btn btn-icon" title="Bình luận"><i class="fas fa-comment"></i></button>
                        </div>
                    </div>
                    <div class="rating">
                        <div class="rating-box">
                            <span class="score">9.0</span>
                            <span class="source">IMDb</span>
                        </div>
                    </div>
                </div>

                <div class="hero-tabs">
                    <ul class="nav nav-tabs" id="movieTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="episodes-tab" data-toggle="tab" href="#episodes" role="tab" aria-controls="episodes" aria-selected="true">Tập phim</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="gallery-tab" data-toggle="tab" href="#gallery" role="tab" aria-controls="gallery" aria-selected="false">Gallery</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="actors-tab" data-toggle="tab" href="#actors" role="tab" aria-controls="actors" aria-selected="false">Diễn viên</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="suggest-tab" data-toggle="tab" href="#suggest" role="tab" aria-controls="suggest" aria-selected="false">Đề xuất</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container page-content">
        <div class="row">
            {{-- Main content --}}
            <div class="col-lg-9">
                <div class="tab-content" id="movieTabContent">
                    {{-- Episodes Tab --}}
                    <div class="tab-pane fade show active" id="episodes" role="tabpanel" aria-labelledby="episodes-tab">
                        <div class="notif-bar">Tập 1-5 vietsub 12:00 ngày 12-11-2023. Các bạn đón xem nhé!!</div>
                        <div class="section-heading d-flex justify-content-between align-items-center">
                            <h2 class="section-title"><i class="fas fa-list-ul"></i> Phần 1</h2>
                            <span class="text-muted">10 tập</span>
                        </div>
                        <div class="episode-grid">
                            <a href="#" class="episode-btn">Tập 1</a>
                            <a href="#" class="episode-btn">Tập 2</a>
                            <a href="#" class="episode-btn">Tập 3</a>
                            <a href="#" class="episode-btn">Tập 4</a>
                            <a href="#" class="episode-btn">Tập 5</a>
                            <a href="#" class="episode-btn disabled">Tập 6</a>
                            <a href="#" class="episode-btn disabled">Tập 7</a>
                            <a href="#" class="episode-btn disabled">Tập 8</a>
                            <a href="#" class="episode-btn disabled">Tập 9</a>
                            <a href="#" class="episodebtn disabled">Tập 10</a>
                        </div>
                    </div>

                    {{-- Other tabs (placeholder) --}}
                    <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">...</div>
                    <div class="tab-pane fade" id="actors" role="tabpanel" aria-labelledby="actors-tab">...</div>
                    <div class="tab-pane fade" id="suggest" role="tabpanel" aria-labelledby="suggest-tab">
                        <div class="movie-grid">
                             @foreach($related as $r)
                                <div class="movie-card">
                                    <a href="{{ route('movies.show', $r->movie_id) }}">
                                        <img src="{{ asset('img/' . $r->image) }}" alt="{{ $r->movie_name }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $r->movie_name }}</h5>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Comments Section --}}
                <div id="comments" class="comments-section">
                    <div class="section-heading d-flex justify-content-between align-items-center">
                        <h2 class="section-title"><i class="fas fa-comments"></i> Bình luận ({{ $movie->comments()->where('status', 1)->count() }})</h2>
                        <div class="comment-sort">Sắp xếp</div>
                    </div>

                    @auth
                        <form action="{{ route('comments.store', $movie->movie_id) }}" method="POST" class="comment-form mb-4">
                            @csrf
                            <div class="form-group">
                                <textarea name="content" class="form-control" rows="3" placeholder="Viết bình luận của bạn..."></textarea>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                            </div>
                        </form>
                    @else
                        <p class="text-center"><a href="{{ route('login') }}">Đăng nhập</a> để bình luận.</p>
                    @endauth

                    <div class="comments-list">
                        @forelse ($movie->comments()->where('status', 1)->latest()->get() as $comment)
                            <div class="comment-item">
                                <div class="comment-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="comment-body">
                                    <div class="comment-header">
                                        <span class="username">{{ $comment->user->name }}</span>
                                        <span class="timestamp">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="comment-content">
                                        <p>{{ $comment->content }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">Chưa có bình luận nào.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-3">
                <div class="movie-detail-sidebar">
                    <div class="poster-sm">
                        <img src="{{ asset('img/' . $movie->image) }}" alt="{{ $movie->movie_name }}">
                    </div>
                    <h4 class="title-sm">{{ $movie->movie_name }}</h4>
                    <div class="tags">
                        @if($movie->category)
                            <a href="#" class="tag">{{ $movie->category->cat_name }}</a>
                        @endif
                        @if($movie->genre)
                            <a href="#" class="tag">{{ $movie->genre->genre_name }}</a>
                        @endif
                         @if($movie->country)
                            <a href="#" class="tag">{{ $movie->country->country_name }}</a>
                        @endif
                    </div>
                    <div class="d-grid my-2">
                         <a href="{{ route('movie.watch', $movie->movie_id) }}" class="btn btn-primary"><i class="fas fa-play"></i> Xem phim</a>
                    </div>
                    <div class="description">
                        <h5>Giới thiệu:</h5>
                        <p>{{ $movie->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@auth
<!-- Playlist Modal (can be reused or removed if not needed in new UI) -->
@endauth
