<div class="container auth-wrapper" style="min-height:calc(100vh - 120px);display:flex;align-items:center;justify-content:center;">
    <div class="auth-card" style="width:100%;max-width:560px;background:#0c0e12;border:1px solid rgba(255,255,255,.08);border-radius:16px;box-shadow:0 14px 50px rgba(0,0,0,.45), inset 0 1px 0 rgba(255,255,255,.04);padding:24px 24px;">
        <div class="text-center mb-3">
            <img src="{{ asset('/FE/img/logo.png') }}" alt="logo" width="54" height="54" style="opacity:.9;">
        </div>

        <div class="auth-tabs mb-3">
            <button type="button" class="auth-tab-btn" data-tab="login">{{ __('messages.login') }}</button>
            <button type="button" class="auth-tab-btn" data-tab="register">{{ __('messages.register') }}</button>
        </div>

        <div class="tab-panels">
            <!-- Login Panel -->
            <div class="tab-panel" id="panel-login">
                <h2 class="auth-title">{{ __('messages.welcome_back') }}</h2>
                @if (session('status'))
                    <div class="alert alert-success py-2 px-3 mb-2" role="alert">{{ session('status') }}</div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="text-light" style="opacity:.9;">{{ __('messages.email_address') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control auth-input" required autofocus autocomplete="username">
                        @error('email')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="password" class="text-light" style="opacity:.9;">{{ __('messages.password') }}</label>
                        <input id="password" type="password" name="password" class="form-control auth-input" required autocomplete="current-password">
                        @error('password')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="remember_me" name="remember">
                            <label class="custom-control-label text-muted" for="remember_me">{{ __('messages.remember_me') }}</label>
                        </div>
                        @if (Route::has('password.request'))
                        <a class="text-muted" href="{{ route('password.request') }}" style="text-decoration:underline;">{{ __('messages.forgot_password_link') }}</a>
                        @endif
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-cta" style="min-width:140px;">{{ __('messages.log_in_button') }}</button>
                    </div>
                </form>
            </div>

            <!-- Register Panel -->
            <div class="tab-panel" id="panel-register">
                <h2 class="auth-title">{{ __('messages.create_account') }}</h2>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="text-light" style="opacity:.9;">{{ __('messages.name') }}</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control auth-input" required autocomplete="name">
                        @error('name')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="reg_email" class="text-light" style="opacity:.9;">{{ __('messages.email_address') }}</label>
                        <input id="reg_email" type="email" name="email" value="{{ old('email') }}" class="form-control auth-input" required autocomplete="email">
                        @error('email')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="reg_password" class="text-light" style="opacity:.9;">{{ __('messages.password') }}</label>
                        <input id="reg_password" type="password" name="password" class="form-control auth-input" required autocomplete="new-password">
                        @error('password')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="password_confirmation" class="text-light" style="opacity:.9;">{{ __('messages.confirm_password') }}</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control auth-input" required autocomplete="new-password">
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-cta" style="min-width:140px;">{{ __('messages.register_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    (function(){
        const initial = @json(($initialTab ?? request('tab')) === 'register' ? 'register' : 'login');
        const $btns = $('.auth-tab-btn');
        const $panels = $('.tab-panel');
        function activate(tab){
            $btns.removeClass('active');
            $btns.filter('[data-tab="'+tab+'"]').addClass('active');
            $panels.hide();
            $('#panel-'+tab).show();
        }
        $(document).on('click','.auth-tab-btn',function(){ activate($(this).data('tab')); });
        activate(initial);
    })();
</script>

