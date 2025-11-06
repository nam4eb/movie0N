@extends('layout')
@section('content')
<div class="container news-page" style="margin-top:20px;">
  <div class="row">
    <div class="col-lg-9">
      <div class="news-header d-flex align-items-center justify-content-between">
        <h2 class="mb-0">New & Popular</h2>
        <span class="text-muted" style="font-size:14px;">Cập nhật mỗi ngày</span>
      </div>

      <div class="news-list">
        @forelse($news as $item)
          <article class="news-card mb-3">
            @if($item->image_path)
              <a href="{{ route('news.show', $item->slug) }}" class="thumb">
                <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}">
              </a>
            @endif
            <div class="content">
              <h3 class="news-title"><a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a></h3>
              <div class="news-meta">
                <small>{{ optional($item->published_at ?? $item->created_at)->format('d/m/Y H:i') }}</small>
              </div>
              <p class="news-excerpt">{{ $item->excerpt }}</p>
              <a href="{{ route('news.show', $item->slug) }}" class="btn btn-sm btn-primary">Đọc tiếp</a>
            </div>
          </article>
        @empty
          <p>Chưa có bài viết.</p>
        @endforelse
      </div>

      <div class="pagination-wrapper">
        {{ $news->links() }}
      </div>
    </div>

    <div class="col-lg-3">
      <aside class="news-sidebar">
        <div class="sidebar-widget">
          <img src="{{ asset('img/ads3.png') }}" alt="Ad" style="width:100%;border-radius:10px;">
        </div>
      </aside>
    </div>
  </div>
</div>
@endsection
