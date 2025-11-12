@extends('layout')

@section('content')
<div class="container auth-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card auth-card">
                <h2 class="auth-title text-center mb-4">{{ __('messages.reset_password') }}</h2>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email">{{ __('Email') }}</label>
                        <input id="email" class="form-control auth-input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus>
                        @error('email')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" class="form-control auth-input" type="password" name="password" required autocomplete="new-password">
                        @error('password')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                        <input id="password_confirmation" class="form-control auth-input" type="password" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-cta">
                            {{ __('messages.reset_password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
