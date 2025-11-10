@extends('layout')
@section('content')

<div class="container">
	<div class="row">
		<div class="main-watch-detail text-center">
            {{-- Video Player --}}
			<div class="media-player box-player" id="media-player-box">
                <iframe class="mb-iframe" width="100%" height="500" src="https://www.youtube.com/embed/7-e_S63rX9E?autoplay=1" frameborder="0" scrolling="no" allowfullscreen=""></iframe>
            </div>

            {{-- Action Buttons --}}
			<div class="feature d-flex">
				<div class="col-6 text-left">
					<button class="btn btn-outline-light"><i class="fas fa-expand-arrows-alt"></i> Mở rộng</button>
					<button class="btn btn-outline-light"><i class="fas fa-share-alt"></i> Chia sẻ</button>
				</div>
				<div class="col-6 text-right">
					<button class="btn btn-outline-light"><i class="fas fa-ban"></i> Tắt đèn</button>
					<button class="btn btn-outline-light"><i class="fas fa-step-forward"></i> Tập tiếp</button>
					<button class="btn btn-outline-light"><i class="fa fa-warning"></i> Báo lỗi</button>
				</div>
			</div>

            {{-- Server & Episode List --}}
			<div class="server d-flex">
				<h4><i class="fas fa-database"></i> Server</h4>
				<button class="btn btn-outline-light ml-4">#Vietsub</button>
			</div>
			<div class="episode d-flex">
				<h4><i class="far fa-list-alt"></i> Tập phim</h4>
				<button class="btn btn-outline-light ml-4 active">1</button>
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
                    <h3 class="text-left mb-3">Phim liên quan</h3>
					<div class="related-scroll-container">
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