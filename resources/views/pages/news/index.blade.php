@extends('layout')
@section('content')
<div class="container news-page" style="margin-top:20px;">
  <div class="row">
    <div class="col-lg-9">
      <div class="news-header d-flex align-items-center justify-content-between">
        <h2 class="mb-0">{{ __('messages.new_popular') }}</h2>
      </div>

      {{-- Featured Article --}}
      @if($featuredArticle)
      <div class="featured-article-card my-3">
        @if($featuredArticle->image_path)
        <a href="{{ route('news.show', $featuredArticle->slug) }}">
          <img src="{{ asset($featuredArticle->image_path) }}" alt="{{ $featuredArticle->title }}" class="featured-img">
        </a>
        @endif
        <div class="featured-content">
          <h3 class="news-title"><a href="{{ route('news.show', $featuredArticle->slug) }}">{{ $featuredArticle->title }}</a></h3>
          <p class="news-excerpt">{{ $featuredArticle->excerpt }}</p>
          <a href="{{ route('news.show', $featuredArticle->slug) }}" class="btn btn-sm btn-primary">{{ __('messages.read_more') }}</a>
        </div>
      </div>
      @endif

      {{-- Rest of the news --}}
      <div class="news-list-regular mt-4">
        @forelse($news as $item)
          <article class="news-card-sm mb-3">
            @if($item->image_path)
              <a href="{{ route('news.show', $item->slug) }}" class="thumb-sm">
                <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}">
              </a>
            @endif
            <div class="content">
              <h4 class="news-title"><a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a></h4>
              <div class="news-meta">
                <small>{{ optional($item->published_at ?? $item->created_at)->format('d/m/Y') }}</small>
              </div>
            </div>
          </article>
        @empty
          <p>{{ __('messages.no_articles_found') }}</p>
        @endforelse
      </div>

      <div class="pagination-wrapper">
        {{ $news->links() }}
      </div>
    </div>

    <div class="col-lg-3">
      <aside class="news-sidebar">
        {{-- Popular Movies --}}
        @if(isset($popularMovies) && $popularMovies->count())
        <div class="sidebar-widget">
          <h4 class="widget-title">{{ __('messages.popular_this_week') }} - {{ __('messages.movies') }}</h4>
          <div class="popular-list">
            @foreach($popularMovies as $movie)
            <a href="{{ route('movies.show', $movie->movie_id) }}" class="popular-item">
              <img src="{{ asset('img/' . $movie->image) }}" alt="{{ $movie->movie_name }}">
              <span>{{ $movie->movie_name }}</span>
            </a>
            @endforeach
          </div>
        </div>
        @endif

        {{-- Popular TV Shows --}}
        @if(isset($popularTvShows) && $popularTvShows->count())
        <div class="sidebar-widget">
          <h4 class="widget-title">{{ __('messages.popular_this_week') }} - {{ __('messages.tv_shows') }}</h4>
          <div class="popular-list">
            @foreach($popularTvShows as $movie)
            <a href="{{ route('movies.show', $movie->movie_id) }}" class="popular-item">
              <img src="{{ asset('img/' . $movie->image) }}" alt="{{ $movie->movie_name }}">
              <span>{{ $movie->movie_name }}</span>
            </a>
            @endforeach
          </div>
        </div>
        @endif
      </aside>
    </div>
  </div>
</div>
@endsection
