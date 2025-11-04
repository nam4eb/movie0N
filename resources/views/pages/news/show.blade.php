@extends('layout')
@section('content')
<div class="container" style="margin-top:20px;">
  <div class="row">
    <div class="col-lg-9">
      <article class="card" style="background:#1a1c20;color:#fff;border:none;">
        @if($article->image_path)
          <img src="{{ asset($article->image_path) }}" alt="{{ $article->title }}" style="width:100%;max-height:380px;object-fit:cover;border-radius:6px 6px 0 0;">
        @endif
        <div class="card-body">
          <h2>{{ $article->title }}</h2>
          <small class="text-muted">{{ optional($article->published_at ?? $article->created_at)->format('d/m/Y H:i') }}</small>
          @if($article->excerpt)
            <p class="mt-2"><em>{{ $article->excerpt }}</em></p>
          @endif
          <div class="mt-3">
            {!! nl2br(e($article->content)) !!}
          </div>
        </div>
      </article>
    </div>

    <div class="col-lg-3">
      <div class="sidebar-widget">
        <h4 class="widget-title">Bài viết mới</h4>
        @foreach(\App\Models\News::where('is_published', true)->orderByDesc('published_at')->limit(5)->get() as $n)
          <div class="coming-soon-item">
            <div class="item-content">
              <a href="{{ route('news.show', $n->slug) }}">{{ $n->title }}</a>
              <span>{{ optional($n->published_at ?? $n->created_at)->format('d/m/Y') }}</span>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection

