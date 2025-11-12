@extends('layout')
@section('content')

<div class="container" style="margin-top:20px;">
    <div class="row">
        <div class="col-lg-9 main-content-area">
            {{-- Hero section inspired by reference UI --}}
            @if(isset($featuredMovie))
                <div class="hero-section" id="heroSection" style="background-image:url('{{ asset('img/' . $featuredMovie->image) }}')">
                    <div class="hero-content">
                        <div class="text-muted small mb-2">{{ $featuredMovie->country->country_name ?? 'Movie' }} • {{ $featuredMovie->release_year ?? $featuredMovie->created_at?->format('Y') }}</div>
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
                <h2>{{ __('messages.latest_movies') }}</h2>
                <div class="wide-scroll" id="theatricalScroll">
                    @foreach($theatricalHighlights as $m)
                        <a class="wide-card" href="{{ route('movies.show', $m->movie_id) }}">
                            <img src="{{ asset('img/' . $m->image) }}" alt="{{ $m->movie_name }}">
                            <div class="wide-meta">
                                <div class="title">{{ $m->movie_name }}</div>
                                <div class="sub">{{ $m->country->country_name ?? 'Movie' }} • {{ $m->release_year ?? $m->created_at?->format('Y') }}</div>
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
                <h2>{{ __('messages.top_movies_today') }}</h2>
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
                <h2>{{ __('messages.latest_japanese_movies') }}</h2>
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

                @if(isset($continueWatching) && $continueWatching->count())
                <div class="movie-list">
                    <h2>{{ __('messages.continue_watching') }}</h2>
                    <div class="wide-scroll" id="continueScroll">
                        @foreach($continueWatching as $cw)
                            @php($m = $cw->movie)
                            <a class="wide-card" href="{{ route('movie.watch', $m->movie_id) }}@if($cw->episode_id)?ep={{ $cw->episode_id }}@endif">
                                <img src="{{ asset('img/' . $m->image) }}" alt="{{ $m->movie_name }}">
                                <div class="wide-meta">
                                    <div class="title">{{ $m->movie_name }}</div>
                                    @php($pct = $cw->duration ? min(100, intval($cw->position*100/ max(1,$cw->duration))) : 0)
                                    <div class="sub">Đang xem • {{ $pct }}%</div>
                                    <div class="progress" style="height:4px;background:#333;margin-top:6px;border-radius:2px;overflow:hidden;">
                                        <div style="width: {{ $pct }}%; height:100%; background:#f59e0b;"></div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(isset($recommended) && $recommended->count())
                <div class="movie-list">
                    <h2>{{ __('messages.because_you_watched') }}</h2>
                    <div class="wide-scroll" id="recommendScroll">
                        @foreach($recommended as $m)
                            <a class="poster-card" href="{{ route('movies.show', $m->movie_id) }}">
                                <img src="{{ asset('img/' . $m->image) }}" alt="{{ $m->movie_name }}">
                                <div class="p-title">{{ $m->movie_name }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif




            {{-- Coming soon horizontal list --}}
            @if(isset($comingSoonMovies) && $comingSoonMovies->count())
            <div class="movie-list" style="margin-top:10px;">
                <h2>{{ __('messages.coming_soon') }}</h2>
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
                    <h2>{{ __('messages.latest_movies') }} <i class="glyphicon glyphicon-fire"></i></h2>
                    <div class="movie-grid">
                        @foreach(($topMovies ?? collect()) as $movie)
                            <div class="movie-card">
                                <img src="{{ asset('img/' . $movie->image) }}" alt="{{ $movie->movie_name }}">
                                <div class="movie-name"><h2>{{ $movie->movie_name }}</h2></div>
                                <div class="movie-feature d-flex">
                                    <a class="btn btn-md btn-light" href="{{ route('movies.show', $movie->movie_id) }}">Watch <i class="fas fa-play"></i></a>
                                    @auth
                                    <form method="POST" action="{{ route('favorites.toggle', $movie->movie_id) }}" class="favorite-toggle-form" data-movie-id="{{ $movie->movie_id }}" style="margin-left:6px;">
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

                {{-- Top TV Series --}}
                <div class="movie-list tv-series">
                    <h2>{{ __('messages.latest_tv_shows') }} <i class="glyphicon glyphicon-fire"></i></h2>
                    <div class="movie-grid">
                        @foreach(($topTvSeries ?? collect()) as $movie)
                            <div class="movie-card">
                                <img src="{{ asset('img/' . $movie->image) }}" alt="{{ $movie->movie_name }}">
                                <div class="movie-name"><h2>{{ $movie->movie_name }}</h2></div>
                                <div class="movie-feature d-flex">
                                    <a class="btn btn-md btn-light" href="{{ route('movies.show', $movie->movie_id) }}">Watch <i class="fas fa-play"></i></a>
                                    @auth
                                    <form method="POST" action="{{ route('favorites.toggle', $movie->movie_id) }}" class="favorite-toggle-form" style="margin-left:6px;">
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
                    <h2>{{ __('messages.korean_dramas') }} <i class="glyphicon glyphicon-fire"></i></h2>
                    <div class="movie-grid">
                        @foreach($topKoreanTvSeries as $movie)
                            <div class="movie-card">
                                <img src="{{ asset('img/' . $movie->image) }}" alt="{{ $movie->movie_name }}">
                                <div class="movie-name"><h2>{{ $movie->movie_name }}</h2></div>
                                <div class="movie-feature d-flex">
                                    <a class="btn btn-md btn-light" href="{{ route('movies.show', $movie->movie_id) }}">Watch <i class="fas fa-play"></i></a>
                                    @auth
                                    <form method="POST" action="{{ route('favorites.toggle', $movie->movie_id) }}" class="favorite-toggle-form" style="margin-left:6px;">
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
                    <h2>{{ __('messages.latest_anime') }}</h2>
                    <div class="hero-section" id="animeHero" style="background-image:url('{{ asset('img/' . $spot->image) }}'); height:420px;">
                        <div class="hero-content">
                            <div class="text-muted small mb-2">Anime • {{ $spot->release_year ?? $spot->created_at?->format('Y') }}</div>
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
            <form action="/playlists/{{ $playlist->id }}/movies" data-base-action="/playlists/{{ $playlist->id }}/movies" method="POST" class="d-inline playlist-add-form mb-2">
                @csrf
                <input type="hidden" name="movie_id" value="">
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
    // Simple toast helper
    function showToast(message, type){
        const $t = $('<div/>', { class: 'alert alert-'+(type||'success'),
            text: message,
            css: {
                position:'fixed', right:'16px', top:'16px', zIndex: 9999,
                minWidth:'260px', background:'#1e293b', color:'#fff', border:'1px solid #334155'
            }
        });
        $('body').append($t);
        setTimeout(()=>{ $t.fadeOut(300, ()=> $t.remove()); }, 2000);
    }

    // Attach data to modal from clicked button
    $(document).on('click', '.add-to-playlist-btn', function(){
        const movieId = $(this).data('movie-id');
        const title = $(this).data('movie-name') || 'Add to a playlist';
        $('#playlistModalHomeLabel').text("Add '"+title+"' to a playlist");
        $('#playlistModalHome').data('movie-id', movieId);
    });

    // When modal is shown, update form actions with movie id
    $('#playlistModalHome').on('show.bs.modal', function(e){
        // Prefer movie id from the clicked trigger
        const trigger = $(e.relatedTarget);
        const mid = trigger && trigger.data('movie-id') ? trigger.data('movie-id') : $(this).data('movie-id');
        if (!mid) return; // Avoid writing 'undefined' in URL
        const $modal = $(this);
        // Update each form: set hidden input and ensure action targets route with movie id in path
        $modal.find('form.playlist-add-form').each(function(){
            const $form = $(this);
            const base = $form.data('base-action') || $form.attr('action');
            // Always use body endpoint /playlists/{id}/movies
            if (base) {
                $form.attr('action', base.replace(/\/$/, ''));
            }
            $form.find('input[name="movie_id"]').val(mid);
        });
    });

    // Submit add-to-playlist via AJAX and show confirmation
    $(document).on('submit', 'form.playlist-add-form', function(e){
        e.preventDefault();
        const $form = $(this);
        let url = $form.attr('action');
        // Always use body endpoint /playlists/{id}/movies with movie_id in body
        const mid = $('#playlistModalHome').data('movie-id');
        if (mid) {
            $form.find('input[name="movie_id"]').val(mid);
        }
        const data = $form.serialize();
        const $btn = $form.find('button[type="submit"]');
        $btn.prop('disabled', true);
        $.ajax({ url: url, method: 'POST', data: data, dataType: 'json', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } })
            .done(function(res){
                const msg = (res && res.message) ? res.message : 'Đã thêm vào playlist.';
                showToast(msg, 'success');
                $('#playlistModalHome').modal('hide');
            })
            .fail(function(xhr){
                // If route-model-binding 404, fallback to body endpoint /playlists/{id}/movies
                const bodyText = (xhr && (xhr.responseText || '')) + '';
                if (xhr.status === 404 && /No query results for model|NotFoundHttpException/i.test(bodyText) && !$form.data('retried')) {
                    const base = $form.data('base-action') || ($form.attr('action') || '').replace(/\/(\d+)$/, '');
                    $form.data('retried', true);
                    $.ajax({ url: base, method: 'POST', data: $form.serialize(), dataType: 'json', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } })
                        .done(function(res2){
                            const msg2 = (res2 && res2.message) ? res2.message : 'Đã thêm vào playlist.';
                            showToast(msg2, 'success');
                            $('#playlistModalHome').modal('hide');
                        })
                        .fail(function(xhr2){
                            let msg2 = 'Có lỗi xảy ra. Vui lòng thử lại.';
                            if (xhr2.status === 419) msg2 = 'Phiên làm việc hết hạn, hãy tải lại trang.';
                            else if (xhr2.status === 403) msg2 = 'Bạn không có quyền thực hiện thao tác này.';
                            else if (xhr2.status === 404) msg2 = 'Không tìm thấy phim. Hãy tải lại trang rồi thử lại.';
                            console.log('Add to playlist fallback failed', xhr2.status, xhr2.responseText);
                            showToast(msg2, 'danger');
                        })
                        .always(function(){ $btn.prop('disabled', false); });
                    return; // Stop here; we handled retry
                }
                let msg = 'Có lỗi xảy ra. Vui lòng thử lại.';
                if (xhr.status === 419) msg = 'Phiên làm việc hết hạn, hãy tải lại trang.';
                else if (xhr.status === 403) msg = 'Bạn không có quyền thực hiện thao tác này.';
                else if (xhr.status === 404) msg = 'Không tìm thấy phim. Hãy tải lại trang rồi thử lại.';
                console.log('Add to playlist failed', xhr.status, xhr.responseText);
                showToast(msg, 'danger');
            })
            .always(function(){ $btn.prop('disabled', false); });
    });
})();
</script>
@endauth

        </div>

        {{-- Sidebar (kept as original style) --}}
        <div class="col-lg-3 sidebar-area">
            <div class="sidebar-widget">
                <h4 class="widget-title">{{ __('messages.coming_soon') }} <i class="fab fa-algolia"></i></h4>
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
                <h4 class="widget-title">{{ __('messages.top_movies_this_month') }} <i class="glyphicon glyphicon-fire"></i></h4>
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
