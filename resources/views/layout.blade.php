<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    <title>movie0N</title>
    <!-- Google Font: Momo Trust Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Momo+Trust+Display&display=swap" rel="stylesheet">

    <link href="{{asset('/FE/img/logo.png')}}" rel="icon">
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('/FE/css/index.css')}}">
    <link rel="stylesheet" href="{{asset('/FE/assets/fontawesome/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('/FE/assets/font-awesome-4.7.0/css/font-awesome.min.css')}}">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
    <div id="header">
        <nav class="navbar navbar-expand-sm">
            <div class="container-fluid">
                <div class="nav-left">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{asset('/FE/img/logo.png')}}" alt="logo" width="48">
                    </a>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tvshows.index') }}">{{ __('messages.tv_shows') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('movies.index') }}">{{ __('messages.movies') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('genres.index') }}">{{ __('messages.genres') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('news.index') }}">{{ __('messages.new_popular') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('favorites') }}">{{ __('messages.my_list') }}</a></li>
                    </ul>
                    <form class="form-search" onsubmit="return false;">
                        <input id="searchOpenInput" class="form-control" type="text" placeholder="{{ __('messages.search') }}" readonly>
                        <i class="fas fa-search"></i>
                    </form>
                </div>
                <div class="nav-right">
                    @auth
                    <div class="dropdown d-inline-block" id="notification-dropdown-container">
                        <div class="noti" id="notification-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor:pointer;">
                            <i class="material-icons">notifications</i>
                            <span class="badge badge-danger" id="notification-count" style="position:absolute;top:-5px;right:-5px;display:none;"></span>
                        </div>
                        <div class="dropdown-menu dropdown-menu-right notification-panel" aria-labelledby="notification-icon">
                            <div class="notification-header">
                                <h4>{{ __('messages.notifications') }}</h4>
                            </div>
                            <div class="notification-body" id="notification-list">
                                <div class="text-center p-3 text-muted">{{ __('messages.loading') }}</div>
                            </div>
                            <div class="notification-footer">
                                <a href="#">{{ __('messages.view_all_notifications') }}</a>
                            </div>
                        </div>
                    </div>
                    @endauth
                    <div class="theme-toggle">
                        <button id="themeToggle" class="theme-chip" aria-pressed="false">
                            <i class="fas fa-moon"></i>
                        </button>
                    </div>
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" id="languageSwitcher" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-globe"></i> {{ strtoupper(app()->getLocale()) }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languageSwitcher">
                            <a class="dropdown-item" href="{{ route('language.switch', 'en') }}">English (EN)</a>
                            <a class="dropdown-item" href="{{ route('language.switch', 'vi') }}">Tiếng Việt (VI)</a>
                        </div>
                    </div>
                    <div class="user d-flex align-items-center">
                        @guest
                            <div class="auth-buttons">
                                <a href="{{ route('login') }}" class="btn-auth btn-login-outline"><i class="fas fa-sign-in-alt"></i> <span>{{ __('messages.join') }}</span></a>
                            </div>
                        @else
                            <a href="{{ route('profile.show') }}" class="mr-2" style="color:inherit;text-decoration:none;"><i class="fas fa-user-tie"></i></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm">{{ __('messages.logout') }}</button>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <!-- Search Overlay Modal -->
    <div id="searchOverlay" class="search-overlay" style="display:none;">
        <div class="search-dialog">
            <div class="search-head">
                <i class="fas fa-search"></i>
                <input id="searchInput" type="text" class="search-input" placeholder="{{ __('messages.search_placeholder') }}" autocomplete="off">
                <button class="btn-close-search" aria-label="Close" id="searchCloseBtn"><i class="fas fa-times"></i></button>
            </div>
            <div class="search-body">
                <div class="suggest-section">
                    <h5 class="suggest-title">{{ __('messages.featured_suggestions') }}</h5>
                    <div id="suggestGrid" class="suggest-grid"></div>
                </div>
            </div>
        </div>
    </div>

    @yield('content')



    <footer class="footer">
        <div class="container">
            <div class="footer-social">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
            <ul class="footer-links">
                <li><a href="#">Terms Of Use</a></li>
                <li><a href="#">Privacy-Policy</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
            <div class="footer-copy">
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                <p>&copy; 2024 movie0N. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
    window.translations = {
        'notification_new_episode': "{{ __('messages.notification_new_episode') }}",
        'no_suggestions': "{{ __('messages.no_suggestions') }}"
    };
</script>
<script>
        // Theme toggle script
        (function() {
            const btn = document.getElementById('themeToggle');
            function renderToggle(theme){
                if(!btn) return;
                if(theme === 'light'){
                    btn.innerHTML = '<i class="fas fa-sun"></i>';
                    btn.setAttribute('aria-pressed','true');
                }else{
                    btn.innerHTML = '<i class="fas fa-moon"></i>';
                    btn.setAttribute('aria-pressed','false');
                }
            }
            function applyTheme(theme) {
                if (theme === 'light') {
                    document.body.classList.add('theme-light');
                } else {
                    document.body.classList.remove('theme-light');
                }
                renderToggle(theme);
            }

            const saved = localStorage.getItem('theme') || 'dark';
            applyTheme(saved);
            if (btn) {
                btn.addEventListener('click', function(){
                    const current = document.body.classList.contains('theme-light') ? 'light' : 'dark';
                    const next = current === 'light' ? 'dark' : 'light';
                    localStorage.setItem('theme', next);
                    applyTheme(next);
                });
            }
        })();

        // Search overlay script
        (function(){
            const overlay = $('#searchOverlay');
            const openInput = $('#searchOpenInput');
            const input = $('#searchInput');
            const closeBtn = $('#searchCloseBtn');
            const grid = $('#suggestGrid');
            let currentItems = [];
            let xhr = null;

            function render(items){
                grid.empty();
                if(!items || !items.length){
                    grid.append(`<div class="text-muted" style="grid-column:1/-1;padding:10px 0;">${window.translations.no_suggestions}</div>`);
                    return;
                }
                items.forEach(function(it){
                    const $a = $('<a/>', { class:'suggest-card', href: it.url, title: it.title });
                    $a.append($('<img/>', { src: it.image, alt: it.title }));
                    $a.append($('<div/>', { class:'title', text: it.title }));
                    grid.append($a);
                });
            }

            function fetchSuggest(q){
                if(xhr && xhr.abort) xhr.abort();
                xhr = $.ajax({
                    url: '{{ route('search.suggest') }}',
                    method: 'GET', dataType: 'json', data: { q: q||'' }
                }).done(function(res){
                    currentItems = (res && res.items) ? res.items : [];
                    render(currentItems);
                }).fail(function(){ /* silent */ });
            }

            function open(){
                overlay.show();
                $('body').addClass('modal-open').css('overflow','hidden');
                setTimeout(function(){ input.val('').focus(); }, 10);
                fetchSuggest('');
            }
            function close(){
                overlay.hide();
                $('body').removeClass('modal-open').css('overflow','');
            }

            openInput.on('focus click', open);
            closeBtn.on('click', close);
            overlay.on('click', function(e){ if(e.target === this) close(); });
            $(document).on('keydown', function(e){ if(e.key === 'Escape') close(); });
            input.on('input', function(){ fetchSuggest($(this).val()); });
            input.on('keydown', function(e){
                if(e.key==='Enter'){
                    e.preventDefault();
                    const query = $(this).val();
                    if (query) {
                        window.location.href = '{{ route('search.full') }}?q=' + encodeURIComponent(query);
                    }
                }
            });
        })();

        // Dynamic Notification script
        (function(){
            const container = $('#notification-dropdown-container');
            if (!container.length) return; // Only run for logged-in users

            const countBadge = $('#notification-count');
            const notifList = $('#notification-list');

            function fetchNotifications(){
                $.ajax({
                    url: '{{ route('notifications.index') }}',
                    method: 'GET',
                    dataType: 'json'
                }).done(function(notifications){
                    notifList.empty();
                    if (notifications && notifications.length) {
                        countBadge.text(notifications.length).show();
                        notifications.forEach(function(n){
                            const item = $('<a/>', { class: 'notification-item', href: n.data.url });
                            const message = window.translations.notification_new_episode
                                .replace(':movie_name', `<strong>${n.data.movie_name}</strong>`)
                                .replace(':episode_number', n.data.episode_number);
                            item.append($('<p/>').html(message));
                            item.append($('<span/>', { class: 'text-muted small' }).text(new Date(n.created_at).toLocaleString()));
                            notifList.append(item);
                        });
                    } else {
                        countBadge.hide();
                        notifList.append(`<div class="text-center p-3 text-muted">{{ __('messages.no_new_notifications') }}</div>`);
                    }
                }).fail(function(){
                    notifList.html(`<div class="text-center p-3 text-muted">{{ __('messages.failed_to_load_notifications') }}</div>`);
                });
            }

            fetchNotifications();
            // Optional: refresh notifications every minute
            // setInterval(fetchNotifications, 60000);
        })();
    </script>
        <script>
            // AJAX toggle favorites without page reload
            (function(){
                $(document).on('submit', '.favorite-toggle-form', function(e){
                    e.preventDefault();
                    const $form = $(this);
                    const url = $form.attr('action');
                    const movieId = $form.data('movie-id');
                    const $btn = $form.find('button[type="submit"]');
                    $btn.prop('disabled', true);
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: $form.serialize(),
                        dataType: 'json',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json'
                        }
                    }).done(function(res){
                        const favorited = res && res.favorited;
                        // Toggle all icons of the same movie across the page
                        const $forms = movieId ? $(`.favorite-toggle-form[data-movie-id='${movieId}']`) : $form;
                        $forms.each(function(){
                            const $f = $(this);
                            const $i = $f.find('button[type="submit"] i');
                            if (favorited) {
                                $i.removeClass('far').addClass('fas');
                            } else {
                                $i.removeClass('fas').addClass('far');
                            }
                        });
                    }).fail(function(xhr){
                        if (xhr.status === 401) {
                            window.location.href = '{{ route('login') }}';
                            return;
                        }
                        console.log('Favorite toggle failed', xhr.status, xhr.responseText);
                    }).always(function(){
                        $btn.prop('disabled', false);
                    });
                });
            })();
        </script>

        // Rating form auto-submit
        (function(){
            $(document).on('change', '#rating-form input[type="radio"]', function(){
                $('#rating-form').submit();
            });
        })();

</body>
</html>
