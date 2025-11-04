@extends('layout')

@section('content')
<div class="container profile-page" style="color:#fff; margin-top: 40px;">
    @php($me = isset($user) ? $user : auth()->user())
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background:#0c0e12; border-radius:15px; padding: 30px;">
                <h2 class="mb-4" style="color: #bfa511;">Edit Your Profile</h2>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', optional($me)->name) }}" required style="background: #222; color: #fff; border-color: #444;">
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', optional($me)->email) }}" required style="background: #222; color: #fff; border-color: #444;">
                    </div>

                    <hr style="border-color: #444;">

                    <h5 class="mt-4">Change Password</h5>
                    <p><small>Leave blank if you don't want to change your password.</small></p>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" name="password" id="password" class="form-control" style="background: #222; color: #fff; border-color: #444;">
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" style="background: #222; color: #fff; border-color: #444;">
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
