@extends('layout')

@section('content')
<div class="container auth-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card auth-card">
                <h2 class="auth-title text-center mb-4">{{ __('messages.verify_email') }}</h2>

                <div class="mb-4 text-sm text-muted">
                    {{ __('messages.verify_email_text') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success mb-4">
                        {{ __('messages.verification_link_sent') }}
                    </div>
                @endif

                <div class="mt-4 d-flex align-items-center justify-content-between">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-cta">
                            {{ __('messages.resend_verification_email') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-muted">
                            {{ __('messages.logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
