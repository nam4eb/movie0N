@extends('layout')
@section('content')

<div class="container" style="margin-top:20px;">
    <div class="row">
        <div class="col-lg-9 main-content-area">
            {{-- Hero section inspired by reference UI --}}
            @if(isset($featuredMovie))
                <div class="hero-section" id="heroSection" style="background-image:url('{{ asset('img/' . $featuredMovie->image) }}')">
                    <div class="hero-content">
                        <div class="text-muted small mb-2">{{ $featuredMovie->country->country_name ?? 'Movie' }} • {{ $featuredMovie->created_at?->format('Y') }}</div>
                        <h1 class="hero-title">{{ strtoupper($featuredMovie->movie_name) }}</h1>
                        <div class="hero-description">{{ \Illuminate\Support\Str::limit($featuredMovie->description, 180) }}</div>
                        <div class="hero-buttons">
                            <a href="{{ route('movies.show', $featuredMovie->movie_id) }}" class="btn btn-warning"><i class="fa fa-play"></i> Xem ngay</a>
                            <a href="{{ route('movies.show', $featuredMovie->movie_id) }}" class="btn btn-outline-light"><i class="fa fa-info-circle"></i> Chi tiết</a>
                        </div>
                    </div>
                </div>
                @if(isset($carouselMovies) && $carouselMovies->count())
                <div class="d-flex align-items-center" style="gap:10px; overflow-x:auto; padding-bottom:8px; margin-top:-15px; margin-bottom:25px;">
                    @foreach($carouselMovies as $m)
                        <img class="hero-thumb" data-hero="{{ asset('img/' . $m->image) }}" src="{{ asset('img/' . $m->image) }}" alt="{{ $m->movie_name }}" style="width:110px;height:62px;object-fit:cover;border-radius:8px;cursor:pointer;opacity:.85;">
                    @endforeach
                </div>
                <script>
                    $(function(){
                        $(document).on('click','.hero-thumb',function(){
                            const url = $(this).data('hero');
                            $('#heroSection').css('background-image', 'url("'+url+'")');
                        });
                    });
                </script>
                @endif
            @endif

            {{-- Topic chips --}}
            @if(isset($topGenres) && $topGenres->count())
            <div class="topic-chips">
                <div class="chips-title">Bạn đang quan tâm gì?</div>
                <div class="chips-list">
                    @foreach($topGenres as $g)
                        <a class="chip" href="{{ route('genres.show', $g->genre_id) }}">{{ $g->genre_name }}</a>
                    @endforeach
                    <a class="chip chip-muted" href="{{ route('genres.index') }}">+ Thêm chủ đề</a>
                </div>
            </div>
            @endif

            {{-- Theatrical highlights (Phim Chiếu Rạp) --}}
            @if(isset($theatricalHighlights) && $theatricalHighlights->count())
            <div class="movie-list">
                <h2>Mãn nhãn với Phim Chiếu Rạp</h2>
                <div class="wide-scroll" id="theatricalScroll">
                    @foreach($theatricalHighlights as $m)
                        <a class="wide-card" href="{{ route('movies.show', $m->movie_id) }}">
                            <img src="{{ asset('img/' . $m->image) }}" alt="{{ $m->movie_name }}">
                            <div class="wide-meta">
                                <div class="title">{{ $m->movie_name }}</div>
                                <div class="sub">{{ $m->country->country_name ?? 'Movie' }} • {{ $m->created_at?->format('Y') }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="scroll-arrows">
                    <button class="btn btn-sm btn-secondary" data-target="#theatricalScroll" data-dir="-1"><i class="fa fa-chevron-left"></i></button>
                    <button class="btn btn-sm btn-secondary" data-target="#theatricalScroll" data-dir="1"><i class="fa fa-chevron-right"></i></button>
                </div>
            </div>
            @endif

            {{-- Top 10 phim là hôm nay --}}
            @if(isset($topToday) && $topToday->count())
            <div class="movie-list">
                <h2>Top 10 phim là hôm nay</h2>
                <div class="rank-grid">
                    @foreach($topToday as $row)
                        @php($m = $row->movie)
                        <a class="rank-card" href="{{ route('movies.show', $m->movie_id) }}">
                            <span class="rank-number">{{ $loop->iteration }}</span>
                            <img src="{{ asset('img/' . $m->image) }}" alt="{{ $m->movie_name }}">
                            <div class="r-meta">
                                <div class="title">{{ $m->movie_name }}</div>
                                <div class="sub">{{ $row->views }} lượt xem hôm nay</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Phim Nhật mới oanh tạc chốn này --}}
            @if(isset($latestJapan) && $latestJapan->count())
            <div class="movie-list">
                <h2>Phim Nhật Mới Oanh Tạc Chốn Này</h2>
                <div class="wide-scroll" id="japanScroll">
                    @foreach($latestJapan as $m)
                        <a class="poster-card" href="{{ route('movies.show', $m->movie_id) }}">
                            <img src="{{ asset('img/' . $m->image) }}" alt="{{ $m->movie_name }}">
                            <div class="p-title">{{ $m->movie_name }}</div>
                        </a>
                    @endforeach
                </div>
                <div class="scroll-arrows">
                    <button class="btn btn-sm btn-secondary" data-target="#japanScroll" data-dir="-1"><i class="fa fa-chevron-left"></i></button>
                    <button class="btn btn-sm btn-secondary" data-target="#japanScroll" data-dir="1"><i class="fa fa-chevron-right"></i></button>
                </div>
            </div>
            @endif

            <script>
                $(function(){
                    $(document).on('click', '.scroll-arrows button', function(){
                        const target = $(this).data('target');
                        const dir = parseInt($(this).data('dir'), 10) || 1;
                        const wrap = $(target);
                        wrap.animate({ scrollLeft: wrap.scrollLeft() + dir * 420 }, 250);
                    });
                });
            </script>


            <script>
                $(function(){
                    function autoSlide(containerSel, interval){
                        const $wrap = $(containerSel);
                        if(!$wrap.length) return;
                        const $items = $wrap.children();
                        if($items.length <= 1) return;
                        let idx = 0, timer = null;
                        function go(next){
                            idx = next % $items.length;
                            const $t = $items.eq(idx);
                            const left = $t.position().left + $wrap.scrollLeft();
                            $wrap.stop().animate({ scrollLeft: left }, 400);
                        }
                        function start(){ stop(); timer = setInterval(()=> go(idx+1), interval || 3000); }
                        function stop(){ if(timer){ clearInterval(timer); timer = null; } }
                        $wrap.on('mouseenter', stop).on('mouseleave', start);
                        start();
                    }
                    // Auto slide for horizontal sliders
                    autoSlide('#theatricalScroll', 3200);
                    autoSlide('#japanScroll', 3200);
                    autoSlide('.coming-soon-horizontal', 3200);
                });
            </script>


            {{-- Coming soon horizontal list --}}
            @if(isset($comingSoonMovies) && $comingSoonMovies->count())
            <div class="movie-list" style="margin-top:10px;">
                <h2>Phim sắp tới trên rạp</h2>
                <div class="coming-soon-horizontal">
                    @foreach($comingSoonMovies as $m)
                        <div class="cs-card">
                            <img src="{{ asset('img/' . $m->image) }}" alt="{{ $m->movie_name }}">
                            <div class="cs-meta">
                                <a href="{{ route('movies.show', $m->movie_id) }}">{{ $m->movie_name }}</a>
                                <div class="small text-muted">Đang cập nhật</div>
                            </div>
                        </div>
                    @endforeach
                </div>
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

                {{-- Anime spotlight section --}}
                @if(isset($latestAnime) && $latestAnime->count())
                @php($spot = $latestAnime->first())
                <div class="movie-list" style="margin-top:25px;">
                    <h2>Kho tàng Anime mới nhất</h2>
                    <div class="hero-section" id="animeHero" style="background-image:url('{{ asset('img/' . $spot->image) }}'); height:420px;">
                        <div class="hero-content">
                            <div class="text-muted small mb-2">Anime • {{ $spot->created_at?->format('Y') }}</div>
                            <h2 class="hero-title" style="font-size:2.2rem;">{{ $spot->movie_name }}</h2>
                            <div class="hero-description">{{ \Illuminate\Support\Str::limit($spot->description, 150) }}</div>
                            <div class="hero-buttons">
                                <a href="{{ route('movies.show', $spot->movie_id) }}" class="btn btn-warning"><i class="fa fa-play"></i> Xem ngay</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="gap:10px; overflow-x:auto; padding-bottom:8px; margin-top:-15px;">
                        @foreach($latestAnime as $m)
                            <img class="hero-thumb anime-thumb" data-hero="{{ asset('img/' . $m->image) }}" src="{{ asset('img/' . $m->image) }}" alt="{{ $m->movie_name }}" style="width:90px;height:90px;object-fit:cover;border-radius:12px;cursor:pointer;opacity:.9;">
                        @endforeach
                    </div>
                </div>
                <script>
                    $(function(){
                        $(document).on('click','.anime-thumb',function(){
                            const url = $(this).data('hero');
                            $('#animeHero').css('background-image', 'url("'+url+'")');
                        });
                    });
                </script>
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
