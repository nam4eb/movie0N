@extends('layout')

@section('content')
<div class="container profile-page" style="color:#fff; margin-top: 40px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background:#0c0e12; border-radius:15px; padding: 30px; text-align: center;">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://via.placeholder.com/150' }}" alt="Avatar" class="rounded-circle mx-auto" width="150" height="150">
                <h2 class="mt-4">{{ $user->name }}</h2>
            </div>

            {{-- Recent Comments --}}
            @if($recentComments->count())
            <div class="card mt-4" style="background:#0c0e12; border-radius:15px; padding: 30px;">
                <h4 class="mb-3">{{ __('messages.recent_comments') }}</h4>
                <div class="comments-list">
                    @foreach ($recentComments as $comment)
                        <div class="comment-item mb-3">
                            <div class="comment-body" style="background: #1f2937; border: 1px solid #374151; padding: 12px 16px; border-radius: 12px;">
                                <div class="comment-header d-flex justify-content-between align-items-center mb-1">
                                    <span class="username font-weight-bold">{{ __('commenting_on') }} <a href="{{ route('movies.show', $comment->movie->movie_id) }}">{{ $comment->movie->movie_name }}</a></span>
                                    <span class="timestamp text-muted small">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="comment-content">
                                    <p class="mb-0">{{ $comment->content }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Favorite Movies --}}
            @if($favoriteMovies->count())
            <div class="card mt-4" style="background:#0c0e12; border-radius:15px; padding: 30px;">
                <h4 class="mb-3">{{ __('messages.favorite_movies') }}</h4>
                <div class="movie-grid">
                    @foreach ($favoriteMovies as $movie)
                        @include('components.movie-card-v2', ['movie' => $movie, 'userPlaylists' => collect()])
                    @endforeach
                </div>
            </div>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection

