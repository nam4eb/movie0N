@extends('layout')

@section('content')
<div class="container profile-page" style="color:#fff; margin-top:20px;">
    <div class="row">
        <div class="col-12">
            <h2 style="color: #bfa511;">My Playlists</h2>
        </div>
    </div>

    <div class="row" style="margin-top: 20px;">
        <!-- Create Playlist Form -->
        <div class="col-md-4">
            <div class="card" style="background:#0c0e12;border-radius:12px;padding:16px;margin-bottom:16px;">
                <h3 style="margin-bottom:10px;color:#bfa511;">Create New Playlist</h3>
                <form action="{{ route('playlists.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Playlist Name" required style="background: #222; color: #fff; border-color: #444;">
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>

        <!-- Playlists List -->
        <div class="col-md-8">
            @forelse ($playlists as $playlist)
                <div class="card" style="background:#0c0e12;border-radius:12px;padding:16px;margin-bottom:16px; display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
                    <div>
                        <h4 style="margin:0;">{{ $playlist->name }}</h4>
                        <small>{{ $playlist->movies_count }} movies</small>
                    </div>
                    <a href="#" class="btn btn-sm btn-outline-light">View</a>
                </div>
            @empty
                <p>You haven't created any playlists yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

