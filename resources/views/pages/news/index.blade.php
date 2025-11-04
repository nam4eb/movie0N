@extends('layout')
@section('content')
<div class="container" style="margin-top:20px;">
  <div class="row">
    <div class="col-lg-9">
      <h2 class="mb-3">Tin tức phim</h2>
      @forelse($news as $item)
        <div class="card mb-3" style="background:#1a1c20;color:#fff;border:none;">
          <div class="card-body d-flex">
            @if($item->image_path)
              <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" style="width:160px;height:100px;object-fit:cover;border-radius:6px;margin-right:12px;">
            @endif
            <div>
              <h4 style="margin:0 0 6px 0;"><a href="{{ route('news.show', $item->slug) }}" style="color:#fff;">{{ $item->title }}</a></h4>
              <small class="text-muted">{{ optional($item->published_at ?? $item->created_at)->format('d/m/Y H:i') }}</small>
              <p style="margin-top:6px;">{{ $item->excerpt }}</p>
              <a href="{{ route('news.show', $item->slug) }}" class="btn btn-sm btn-primary">Đọc tiếp</a>
            </div>
          </div>
        </div>
      @empty
        <p>Chưa có bài viết.</p>
      @endforelse

      <div>
        {{ $news->links() }}
      </div>
    </div>

    <div class="col-lg-3">
      <div class="sidebar-widget">
        <img src="{{ asset('img/ads3.png') }}" alt="Ad" style="width:100%;border-radius:10px;">
      </div>
    </div>
  </div>
</div>
@endsection

