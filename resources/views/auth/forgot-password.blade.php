@extends('layout')

@section('content')
<div class="container auth-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card auth-card">
                <h2 class="auth-title text-center mb-4">{{ __('messages.forgot_password') }}</h2>

                <div class="mb-4 text-sm text-muted">
                    {{ __('messages.forgot_password_text') }}
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email">{{ __('Email') }}</label>
                        <input id="email" class="form-control auth-input" type="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-cta">
                            {{ __('messages.email_password_reset_link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
