@extends('layout')
@section('content')
<div class="container" style="margin-top:20px; color:#fff;">
  <h2>Thể loại phim</h2>
  <div class="row" style="margin-top:12px;">
    @forelse(($genres ?? collect()) as $g)
      <div class="col-3" style="margin-bottom:10px;">
        <a class="btn btn-outline-light btn-block" href="{{ route('genres.show', $g->genre_id) }}">{{ $g->genre_name }}</a>
      </div>
    @empty
      <p>Chưa có thể loại.</p>
    @endforelse
  </div>
</div>
@endsection

