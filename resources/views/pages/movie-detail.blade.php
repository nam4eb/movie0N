@extends('layout')
@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="movie-main-content" style="background-image: url('{{ asset('img/' . $movie->image) }}'); background-size: cover;">
			<div class="container d-flex">
				<div class="col-7 text-left">
					<h1>{{ $movie->movie_name }}</h1>
					<div class="d-flex">
						<div class="rate d-flex">
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star-half"></i>
							<p>IMDB</p>
						</div>
						<div class="time ml-3">
							<p>—</p>
						</div>
					</div>
					<p>{{ $movie->description }}</p>
					<a href="{{ route('movie.watch') }}" class="btn btn-outline-light"><i class="fas fa-play mr-2"></i>Play now</a>
                        @auth
						<form method="POST" action="{{ route('favorites.toggle', $movie->movie_id) }}" class="d-inline ml-2">
							@csrf
							<button class="btn btn-danger" type="submit">
								@if(auth()->user()->favorites->contains($movie->movie_id))
									<i class="fas fa-heart mr-1"></i> Favorited
								@else
									<i class="far fa-heart mr-1"></i> Favorite
								@endif
							</button>
						</form>
						<button class="btn btn-success ml-2" data-toggle="modal" data-target="#playlistModal"><i class="far fa-plus-square mr-2"></i>Add to Playlist</button>
						@endauth
				</div>
				<div class="col-5 text-right">
					<a href="#">
						<h1><i class="far fa-play-circle mr-3"></i>Watch trailer</h1>
					</a>
				</div>
			</div>

		</div>
		<div class="container">
			<div class="movie-relate">
				<div class="d-flex">
					@foreach($related as $r)
						<div class="movie-info col-3">
							<img src="{{ asset('img/' . $r->image) }}" alt="{{ $r->movie_name }}">
							<div class="movie-name">
								<h2>{{ $r->movie_name }}</h2>
							</div>
							<div class="movie-feature d-flex">
								<a class="btn btn-md btn-light" href="{{ route('movies.show', $r->movie_id) }}">Watch <i class="fas fa-play"></i></a>
								@auth
								<form method="POST" action="{{ route('favorites.toggle', $r->movie_id) }}">
									@csrf
									<button class="btn btn-md btn-danger" type="submit"><i class="far fa-heart"></i></button>
								</form>
								@endauth
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>

			<!-- Comments Section -->
			<div class="container" style="margin-top: 40px; color: #fff;">
				<div class="row">
					<div class="col-12">
						<h3 style="color: #bfa511; margin-bottom: 20px;">Comments</h3>

						<!-- Comment Form -->
						@auth
							<form action="{{ route('comments.store', $movie->movie_id) }}" method="POST" class="mb-4">
								@csrf
								<div class="form-group">
									<textarea name="content" class="form-control" rows="3" placeholder="Write your comment..." style="background: #222; color: #fff; border-color: #444;"></textarea>
								</div>
								<button type="submit" class="btn btn-primary">Post Comment</button>
							</form>
						@else
							<p><a href="{{ route('login') }}">Log in</a> to post a comment.</p>
						@endauth

						<!-- Comments List -->
						<div class="comments-list">
							@forelse ($movie->comments()->where('status', 1)->latest()->get() as $comment)
								<div class="comment-item" style="background: #1a1c20; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
									<div class="d-flex align-items-center mb-2">
										<div class="avatar" style="width:40px;height:40px;border:1px solid #fff;border-radius:50%;display:flex;align-items-center;justify-content:center;font-size:20px; margin-right: 15px;">
											<i class="fas fa-user"></i>
										</div>
										<div>
											<h5 style="margin: 0;">{{ $comment->user->name }}</h5>
											<small style="opacity: 0.7;">{{ $comment->created_at->diffForHumans() }}</small>
										</div>
									</div>
									<p style="margin: 0;">{{ $comment->content }}</p>
								</div>
							@empty
								<p>No comments yet. Be the first to comment!</p>
							@endforelse
						</div>
					</div>
				</div>
			</div>
	</div>
</div>

@endsection

@auth
<!-- Playlist Modal -->
<div class="modal fade" id="playlistModal" tabindex="-1" role="dialog" aria-labelledby="playlistModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background: #1a1c20; color: #fff;">
      <div class="modal-header">
        <h5 class="modal-title" id="playlistModalLabel">Add '{{ $movie->movie_name }}' to a playlist</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Add to Existing Playlist -->
        <h6>Your Playlists</h6>
        @if($playlists->count() > 0)
            @foreach($playlists as $playlist)
                <form action="{{ route('playlists.movies.add', ['playlist' => $playlist->id, 'movie' => $movie->movie_id]) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light mb-2">{{ $playlist->name }}</button>
                </form>
            @endforeach
        @else
            <p>You have no playlists.</p>
        @endif

        <hr style="border-color: #444;">

        <!-- Create New Playlist -->
        <h6>Create a New Playlist</h6>
        <form action="{{ route('playlists.store') }}" method="POST">
            @csrf
            <div class="input-group">
                <input type="text" name="name" class="form-control" placeholder="New playlist name" required style="background: #222; color: #fff; border-color: #444;">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Create & Add</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endauth

