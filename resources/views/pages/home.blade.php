@extends('layout')
@section('content')

<div class="container" style="margin-top:20px;">
    <div class="row">
        <div class="col-lg-9 main-content-area">
            {{-- Carousel / Hero --}}
            @if(isset($carouselMovies) && $carouselMovies->count())
                <div id="homeCarousel" class="carousel slide" data-ride="carousel" style="margin-bottom:25px;">
                    <ol class="carousel-indicators">
                        @foreach($carouselMovies as $i => $m)
                            <li data-target="#homeCarousel" data-slide-to="{{ $i }}" class="{{ $i==0 ? 'active' : '' }}"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach($carouselMovies as $i => $m)
                            <div class="item {{ $i==0 ? 'active' : '' }}">
                                <img src="{{ asset('img/' . $m->image) }}" alt="{{ $m->movie_name }}">
                                <div class="carousel-caption">
                                    <p>{{ $m->movie_name }}</p>
                                    <div class="d-flex">
                                        <a href="{{ route('movies.show', $m->movie_id) }}" class="btn btn-warning btn-lg">Watch</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="left carousel-control" href="#homeCarousel" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    </a>
                    <a class="right carousel-control" href="#homeCarousel" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    </a>
                </div>
            @endif

            <div class="movie-list-section">
                {{-- Top Movies --}}
                <div class="movie-list">
                    <h2>TOP MOVIE THIS WEEK <i class="glyphicon glyphicon-fire"></i></h2>
                    <div class="movie-grid">
                        @foreach(($topMovies ?? collect()) as $movie)
                            <div class="movie-card">
                                <img src="{{ asset('img/' . $movie->image) }}" alt="{{ $movie->movie_name }}">
                                <div class="movie-name"><h2>{{ $movie->movie_name }}</h2></div>
                                <div class="movie-feature d-flex">
                                    <a class="btn btn-md btn-light" href="{{ route('movies.show', $movie->movie_id) }}">Watch <i class="fas fa-play"></i></a>
                                    @auth
                                    <form method="POST" action="{{ route('favorites.toggle', $movie->movie_id) }}" style="margin-left:6px;">
                                        @csrf
                                        <button class="btn btn-md btn-danger" type="submit">
                                            @if(auth()->user()->favorites->contains($movie->movie_id))
                                                <i class="fas fa-heart"></i>
                                            @else
                                                <i class="far fa-heart"></i>
                                            @endif
                                        </button>
                                    </form>
                                    <button class="btn btn-md btn-success" style="margin-left:6px;" data-toggle="modal" data-target="#playlistModalHome" data-movie-id="{{ $movie->movie_id }}" data-movie-name="{{ $movie->movie_name }}">
                                        <i class="far fa-plus-square"></i>
                                    </button>
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Top TV Series --}}
                <div class="movie-list tv-series">
                    <h2>TOP TV SERIES THIS WEEK <i class="glyphicon glyphicon-fire"></i></h2>
                    <div class="movie-grid">
                        @foreach(($topTvSeries ?? collect()) as $movie)
                            <div class="movie-card">
                                <img src="{{ asset('img/' . $movie->image) }}" alt="{{ $movie->movie_name }}">
                                <div class="movie-name"><h2>{{ $movie->movie_name }}</h2></div>
                                <div class="movie-feature d-flex">
                                    <a class="btn btn-md btn-light" href="{{ route('movies.show', $movie->movie_id) }}">Watch <i class="fas fa-play"></i></a>
                                    @auth
                                    <form method="POST" action="{{ route('favorites.toggle', $movie->movie_id) }}" style="margin-left:6px;">
                                        @csrf
                                        <button class="btn btn-md btn-danger" type="submit">
                                            @if(auth()->user()->favorites->contains($movie->movie_id))
                                                <i class="fas fa-heart"></i>
                                            @else
                                                <i class="far fa-heart"></i>
                                            @endif
                                        </button>
                                    </form>
                                    <button class="btn btn-md btn-success add-to-playlist-btn" style="margin-left:6px;" data-toggle="modal" data-target="#playlistModalHome" data-movie-id="{{ $movie->movie_id }}" data-movie-name="{{ $movie->movie_name }}">
                                        <i class="far fa-plus-square"></i>
                                    </button>
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Top Korean TV Series --}}
                @if(isset($topKoreanTvSeries) && $topKoreanTvSeries->count())
                <div class="movie-list korean-tv-series">
                    <h2>TOP KOREAN TV SERIES <i class="glyphicon glyphicon-fire"></i></h2>
                    <div class="movie-grid">
                        @foreach($topKoreanTvSeries as $movie)
                            <div class="movie-card">
                                <img src="{{ asset('img/' . $movie->image) }}" alt="{{ $movie->movie_name }}">
                                <div class="movie-name"><h2>{{ $movie->movie_name }}</h2></div>
                                <div class="movie-feature d-flex">
                                    <a class="btn btn-md btn-light" href="{{ route('movies.show', $movie->movie_id) }}">Watch <i class="fas fa-play"></i></a>
                                    @auth
                                    <form method="POST" action="{{ route('favorites.toggle', $movie->movie_id) }}" style="margin-left:6px;">
                                        @csrf
                                        <button class="btn btn-md btn-danger" type="submit">
                                            @if(auth()->user()->favorites->contains($movie->movie_id))
                                                <i class="fas fa-heart"></i>
                                            @else
                                                <i class="far fa-heart"></i>
                                            @endif
                                        </button>
                                    </form>
                                    <button class="btn btn-md btn-success add-to-playlist-btn" style="margin-left:6px;" data-toggle="modal" data-target="#playlistModalHome" data-movie-id="{{ $movie->movie_id }}" data-movie-name="{{ $movie->movie_name }}">
                                        <i class="far fa-plus-square"></i>
                                    </button>
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

@auth
<!-- Playlist Modal (Home) -->
<div class="modal fade" id="playlistModalHome" tabindex="-1" role="dialog" aria-labelledby="playlistModalHomeLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background:#1a1c20;color:#fff;">
      <div class="modal-header">
        <h5 class="modal-title" id="playlistModalHomeLabel">Add to a playlist</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Your Playlists</h6>
        @forelse(($playlists ?? collect()) as $playlist)
            <form action="/playlists/{{ $playlist->id }}/movies/__MOVIE_ID__" method="POST" class="d-inline playlist-add-form mb-2" data-base="/playlists/{{ $playlist->id }}/movies/">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light">{{ $playlist->name }}</button>
            </form>
        @empty
            <p>You have no playlists yet.</p>
        @endforelse
        <hr style="border-color:#444;">
        <h6>Create a New Playlist</h6>
        <form action="{{ route('playlists.store') }}" method="POST">
            @csrf
            <div class="input-group">
                <input type="text" name="name" class="form-control" placeholder="New playlist name" required style="background:#222;color:#fff;border-color:#444;">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
    // Attach data to modal from clicked button
    $(document).on('click', '.add-to-playlist-btn', function(){
        const movieId = $(this).data('movie-id');
        const title = $(this).data('movie-name') || 'Add to a playlist';
        $('#playlistModalHomeLabel').text("Add '"+title+"' to a playlist");
        $('#playlistModalHome').data('movie-id', movieId);
    });

    // When modal is shown, update form actions with movie id
    $('#playlistModalHome').on('show.bs.modal', function(){
        const mid = $(this).data('movie-id');
        $(this).find('form.playlist-add-form').each(function(){
            const base = $(this).attr('data-base');
            $(this).attr('action', base + mid);
        });
    });
})();
</script>
@endauth

        </div>

        {{-- Sidebar (kept as original style) --}}
        <div class="col-lg-3 sidebar-area">
            <div class="sidebar-widget">
                <h4 class="widget-title">Movie coming soon <i class="fab fa-algolia"></i></h4>
                <div class="coming-soon-list">
                    @forelse(($comingSoonMovies ?? collect()) as $m)
                        <div class="coming-soon-item">
                            <img src="{{ asset('img/' . $m->image) }}" alt="{{ $m->movie_name }}">
                            <div class="item-content">
                                <a href="{{ route('movies.show', $m->movie_id) }}">{{ $m->movie_name }}</a>
                                <span>Đang cập nhật</span>
                            </div>
                        </div>
                    @empty
                        <div class="coming-soon-item">
                            <img src="{{ asset('img/black-panther.jpg') }}" alt="Black Panther">
                            <div class="item-content">
                                <a href="#">BlackPanther: Wakanda forever</a>
                                <span>(13/07/2022)</span>
                            </div>
                        </div>
                        <div class="coming-soon-item">
                            <img src="{{ asset('img/avatar.jpg') }}" alt="Avatar 2">
                            <div class="item-content">
                                <a href="#">Avatar 2</a>
                                <span>(16/12/2022)</span>
                            </div>
                        </div>
                        <div class="coming-soon-item">
                            <img src="{{ asset('img/thor.jpg') }}" alt="Thor">
                            <div class="item-content">
                                <a href="#">Thor 3: Love and thunder</a>
                                <span>(22/10/2022)</span>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="sidebar-widget">
                <h4 class="widget-title">Top movie this month <i class="glyphicon glyphicon-fire"></i></h4>
                <div class="coming-soon-list">
                    @forelse(($topMoviesThisMonth ?? collect()) as $row)
                        @php($m = $row->movie)
                        <div class="coming-soon-item">
                            <img src="{{ asset('img/' . $m->image) }}" alt="{{ $m->movie_name }}">
                            <div class="item-content">
                                <a href="{{ route('movies.show', $m->movie_id) }}">{{ $m->movie_name }}</a>
                                <span>{{ $row->views }} views</span>
                            </div>
                        </div>
                    @empty
                        <p>Chưa có dữ liệu lượt xem trong tháng.</p>
                    @endforelse
                </div>
            </div>
            <div class="sidebar-widget">
                <img src="{{ asset('img/ads3.png') }}" alt="Cinema Ad" style="width: 100%; border-radius: 10px;">
            </div>
        </div>
    </div>
</div>

@endsection
