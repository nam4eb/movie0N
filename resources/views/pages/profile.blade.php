@extends('layout')

@section('content')
<div class="container profile-page" style="color:#fff; margin-top: 40px;">
    @php($me = isset($user) ? $user : auth()->user())
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background:#0c0e12; border-radius:15px; padding: 30px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0" style="color: #bfa511;">{{ __('messages.edit_your_profile') }}</h2>
                    <a href="{{ route('users.profile', $me) }}" class="btn btn-sm btn-outline-light">{{ __('messages.view_public_profile') }}</a>
                </div>

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

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Avatar -->
                    <div class="form-group">
                        <label for="avatar">{{ __('messages.profile_picture') }}</label>
                        <div class="d-flex align-items-center">
                            <img src="{{ $me->avatar ? asset('storage/' . $me->avatar) : 'https://via.placeholder.com/150' }}" alt="Avatar" class="rounded-circle" width="80" height="80">
                            <input type="file" name="avatar" id="avatar" class="form-control-file ml-3">
                        </div>
                    </div>

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

                    <h5 class="mt-4">{{ __('messages.change_password') }}</h5>
                    <p><small>{{ __('messages.leave_blank_password') }}</small></p>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">{{ __('messages.new_password') }}</label>
                        <input type="password" name="password" id="password" class="form-control" style="background: #222; color: #fff; border-color: #444;">
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation">{{ __('messages.confirm_new_password') }}</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" style="background: #222; color: #fff; border-color: #444;">
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">{{ __('messages.update_profile') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
