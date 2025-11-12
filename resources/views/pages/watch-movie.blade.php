@extends('layout')
@section('content')

<div class="container">
	<div class="row">
		<div class="main-watch-detail text-center">
            {{-- Video Player --}}
			<div class="media-player box-player" id="media-player-box" data-movie-id="{{ $movie->movie_id }}" data-episode-id="{{ $currentEpisode->eps_id ?? '' }}">
                @if(($playerType ?? 'youtube') === 'html5')
                    <video id="v-player" width="100%" height="500" controls playsinline style="background:#000;">
                        <source src="{{ $videoSrc }}" type="{{ \Illuminate\Support\Str::endsWith(strtolower($videoSrc), '.m3u8') ? 'application/x-mpegURL' : 'video/mp4' }}" />
                        @foreach(($subtitles ?? collect()) as $sub)
                            <track src="{{ $sub->vtt_url }}" kind="subtitles" srclang="{{ $sub->lang }}" label="{{ $sub->label }}" {{ $sub->is_default ? 'default' : '' }}>
                        @endforeach
                    </video>
                @else
                    <iframe id="yt-player" class="mb-iframe" width="100%" height="500" src="{{ $embedUrl ?? 'https://www.youtube.com/embed/7-e_S63rX9E?enablejsapi=1&autoplay=1' }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                @endif
            </div>

                @if(($playerType ?? 'youtube') === 'html5' && ($subtitles ?? collect())->count())
                <div class="d-flex align-items-center justify-content-end" style="gap:8px; margin:8px 0 4px;">
                    <label class="mb-0 text-muted">{{ __('messages.subtitles') }}:</label>
                    <select id="subtitleSelect" class="form-control form-control-sm" style="width:auto; background:#111; color:#fff; border-color:#333;">
                        @foreach($subtitles as $sub)
                            <option value="{{ $sub->lang }}" {{ $sub->is_default ? 'selected' : '' }}>{{ $sub->label }}</option>
                        @endforeach
                        <option value="__off">{{ __('messages.subtitles_off') }}</option>
                    </select>
                </div>
                @endif


            {{-- Action Buttons --}}
			<div class="feature d-flex">
				<div class="col-6 text-left">
					<button class="btn btn-outline-light"><i class="fas fa-expand-arrows-alt"></i> {{ __('messages.expand') }}</button>
					<button class="btn btn-outline-light"><i class="fas fa-share-alt"></i> {{ __('messages.share') }}</button>
				</div>
				<div class="col-6 text-right">
					<button class="btn btn-outline-light"><i class="fas fa-ban"></i> {{ __('messages.turn_off_light') }}</button>
					<button class="btn btn-outline-light"><i class="fas fa-step-forward"></i> {{ __('messages.next_episode') }}</button>
					<button class="btn btn-outline-light"><i class="fa fa-warning"></i> {{ __('messages.report_error') }}</button>
				</div>
			</div>

            {{-- Server & Episode List --}}
			<div class="server d-flex align-items-center">
				<h4><i class="fas fa-database"></i> {{ __('messages.server') }}</h4>
				<button class="btn btn-outline-light ml-4">#Vietsub</button>
			</div>
			<div class="episode d-flex align-items-center" style="flex-wrap:wrap; gap:6px;">
				<h4 class="mb-0"><i class="far fa-list-alt"></i> {{ __('messages.episode_list') }}</h4>
				<div class="ml-4 d-flex flex-wrap" style="gap:6px;">
					@forelse(($episodes ?? collect()) as $ep)
						<a class="btn btn-sm {{ ($currentEpisode && $currentEpisode->eps_id === $ep->eps_id) ? 'btn-warning' : 'btn-outline-light' }}" href="{{ route('movie.watch', $movie->movie_id) }}?ep={{ $ep->eps_id }}">{{ $ep->eps_num }}</a>
					@empty
						<span class="text-muted">{{ __('messages.no_episodes_yet') }}</span>
					@endforelse
				</div>
				<div class="ml-auto">
					@if(!empty($prevEpisode))
						<a class="btn btn-outline-light" href="{{ route('movie.watch', $movie->movie_id) }}?ep={{ $prevEpisode->eps_id }}"><i class="fas fa-chevron-left"></i> {{ __('messages.previous_episode') }}</a>
					@endif
					@if(!empty($nextEpisode))
						<a class="btn btn-outline-light ml-2" href="{{ route('movie.watch', $movie->movie_id) }}?ep={{ $nextEpisode->eps_id }}">{{ __('messages.next_episode') }} <i class="fas fa-chevron-right"></i></a>
					@endif
				</div>
			</div>

            {{-- Movie Info --}}
			<div class="desc">
				<div class="d-flex mt-4 mb-4">
					<div class="col-2">
						<img src="{{ asset('img/' . $movie->image) }}" alt="{{ $movie->movie_name }}" width="100%">
					</div>
					<div class="desc-content col-10 text-left">
						<h2>{{ $movie->movie_name }}</h2>
						<div class="meta text-muted" style="margin-bottom:6px;">
							{{ $movie->category->cat_name ?? 'Movie' }} • {{ $movie->genre->genre_name ?? 'Genre' }} • {{ $movie->country->country_name ?? 'Unknown' }} • {{ $movie->release_year ?? $movie->created_at?->format('Y') }}
						</div>
						<p>{{ $movie->description }}</p>
					</div>
				</div>
			</div>
			<hr>

            {{-- Related Movies --}}
			<div class="container">
				<div class="movie-relate">
                    <h3 class="text-left mb-3">{{ __('messages.related_movies') }}</h3>
					<div class="related-scroll-container">

<script>
(function(){
    const box = document.getElementById('media-player-box');
    if (!box) return;
    const movieId = parseInt(box.getAttribute('data-movie-id'));
    const episodeId = box.getAttribute('data-episode-id') || '';
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function ajaxProgress(pos, dur){
        if (!movieId) return;
        $.ajax({
            url: '{{ route('progress.store') }}',
            method: 'POST',
            data: {
                movie_id: movieId,
                episode_id: episodeId || null,
                position_seconds: Math.floor(pos || 0),
                duration_seconds: Math.floor(dur || 0)
            },
            headers: { 'X-CSRF-TOKEN': csrf }
        });
    }

    // HTML5 player branch (mp4/hls)
    const video = document.getElementById('v-player');
    if (video){
        const sourceEl = video.querySelector('source');
        const src = (sourceEl && sourceEl.getAttribute('src')) || '';
        function bindHtml5(){
            let lastSent = 0;
            setInterval(function(){ ajaxProgress(video.currentTime || 0, video.duration || 0); }, 15000);
            video.addEventListener('timeupdate', function(){
                if (Math.abs((video.currentTime||0) - lastSent) >= 10){
                    lastSent = video.currentTime||0;
                    ajaxProgress(lastSent, video.duration||0);
                }
            });
            // Subtitle selector handling
            const sel = document.getElementById('subtitleSelect');
            if (sel) {
                function applySubtitle(lang){
                    const tracks = video.textTracks;
                    for (let i=0;i<tracks.length;i++){
                        const t = tracks[i];
                        // mode: showing | hidden | disabled
                        if (lang === '__off') t.mode = 'disabled'; else t.mode = (t.language === lang || t.label === lang) ? 'showing' : 'disabled';
                    }
                }
                // Initialize state with current selection
                applySubtitle(sel.value);
                sel.addEventListener('change', function(){ applySubtitle(this.value); });
            }
            window.addEventListener('beforeunload', function(){
                try{
                    const data = new URLSearchParams({
                        movie_id: movieId,
                        episode_id: episodeId || '',
                        position_seconds: Math.floor(video.currentTime || 0),
                        duration_seconds: Math.floor(video.duration || 0),
                        _token: csrf
                    });
                    navigator.sendBeacon('{{ route('progress.store') }}', data);
                }catch(e){}
            });
        }
        if (src.toLowerCase().endsWith('.m3u8')){
            if (window.Hls && window.Hls.isSupported()){
                const hls = new Hls();
                hls.loadSource(src);
                hls.attachMedia(video);
                hls.on(Hls.Events.MANIFEST_PARSED, function(){ video.play().catch(()=>{}); });
                bindHtml5();
            } else if (video.canPlayType('application/vnd.apple.mpegurl')){
                bindHtml5();
            } else {
                const s = document.createElement('script');
                s.src = 'https://cdn.jsdelivr.net/npm/hls.js@1.5.7/dist/hls.min.js';
                s.onload = function(){
                    if (window.Hls && window.Hls.isSupported()){
                        const hls = new Hls();
                        hls.loadSource(src);
                        hls.attachMedia(video);
                        hls.on(Hls.Events.MANIFEST_PARSED, function(){ video.play().catch(()=>{}); });
                        bindHtml5();
                    }
                };
                document.body.appendChild(s);
            }
        } else {
            bindHtml5();
        }
        return; // Stop; not using YT branch
    }

    // YouTube branch
    let ytPlayer = null, lastSent = 0;
    function ytTick(){
        if (!ytPlayer || typeof ytPlayer.getCurrentTime !== 'function') return;
        const pos = ytPlayer.getCurrentTime() || 0;
        const dur = ytPlayer.getDuration() || 0;
        if (Math.abs(pos - lastSent) >= 10) {
            lastSent = pos;
            ajaxProgress(pos, dur);
        }
    }
    window.onYouTubeIframeAPIReady = function(){
        const iframe = document.getElementById('yt-player');
        if (!iframe) return;
        ytPlayer = new YT.Player('yt-player', {
            events: {
                onReady: function(){ setInterval(ytTick, 15000); },
                onStateChange: function(e){
                    if (e.data === YT.PlayerState.ENDED) {
                        const d = ytPlayer.getDuration() || 0;
                        ajaxProgress(d, d);
                    }
                }
            }
        });
    };
    const s = document.createElement('script');
    s.src = 'https://www.youtube.com/iframe_api';
    document.body.appendChild(s);

    window.addEventListener('beforeunload', function(){
        try{
            if(!ytPlayer) return;
            const data = new URLSearchParams({
                movie_id: movieId,
                episode_id: episodeId || '',
                position_seconds: Math.floor(ytPlayer.getCurrentTime() || 0),
                duration_seconds: Math.floor(ytPlayer.getDuration() || 0),
                _token: csrf
            });
            navigator.sendBeacon('{{ route('progress.store') }}', data);
        }catch(e){}
    });
})();
</script>

					<div class="d-flex flex-nowrap">
						@foreach($related as $item)
							<div class="movie-info col-3">
								<a href="{{ route('movie.watch', $item->movie_id) }}" class="related-movie-card">
									<img src="{{ asset('img/' . $item->image) }}" alt="{{ $item->movie_name }}">
									<div class="related-movie-title">{{ $item->movie_name }}</div>
								</a>
							</div>
						@endforeach
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection