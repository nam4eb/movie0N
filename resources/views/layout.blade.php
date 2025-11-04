<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>movie0N</title>
    <link href="{{asset('/FE/img/logo.png')}}" rel="icon">
    <link rel="stylesheet" href="{{asset('/FE/css/index.css')}}">
    <link rel="stylesheet" href="{{asset('/FE/assets/fontawesome/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('/FE/assets/font-awesome-4.7.0/css/font-awesome.min.css')}}">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div id="header">
        <nav class="navbar navbar-expand-sm">
            <div class="container">
                <div class="nav-left">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{asset('/FE/img/logo.png')}}" alt="logo" width="48">
                    </a>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tvshows.index') }}">TV Shows</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('movies.index') }}">Movies</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('news.index') }}">New & popular</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('favorites') }}">My List</a></li>
                    </ul>
                </div>
                <div class="nav-right">
                    <form class="form-search">
                        <input class="form-control" type="text" placeholder="Search..">
                        <i class="fas fa-search"></i>
                    </form>
                    <div class="noti">
                        <i class="material-icons">notifications</i>
                    </div>
                    <div class="theme-toggle">
                        <button id="themeToggle" class="btn btn-sm btn-secondary">Light</button>
                    </div>
                    <div class="user d-flex align-items-center">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm mr-2">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                        @else
                            <a href="{{ route('profile.show') }}" class="mr-2" style="color:inherit;text-decoration:none;"><i class="fas fa-user-tie"></i></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm">Logout</button>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
    </div>

    @yield('content')

    <div id="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-flex text-left">
                    <div class="col-3">
                        <ul>
                            <li><img src="img/logo.png" alt="logo" width="66px"></li>
                            <li><h1><u><a href="">Created by Namaeb</a></u></h1></li>
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul>
                            <li><a href="">Lorem ipsum, dolor.</a></li>
                            <li><a href="">Lorem ipsum dolor sit.</a></li>
                            <li><a href="">Lorem ipsum dolor, sit.</a></li>
                            <li><a href="">Lorem ipsum dolor sit.</a></li>
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul>
                            <li><a href="">Lorem ipsum dolor sit.</a></li>
                            <li><a href="">Lorem, ipsum, dolor..</a></li>
                            <li><a href="">Lorem ipsum dolor, sit.</a></li>
                            <li><a href="">Lorem ipsum dolor sit.</a></li>
                        </ul>
                    </div>
                    <div class="col-3">
                        <ul>
                            <li><a href="">Lorem, ipsum dolor.</a></li>
                            <li><a href="">Lorem ipsum dolor sit.</a></li>
                            <li><a href="">Lorem, ipsum, dolor.</a></li>
                            <li><a href="">Lorem ipsum, dolor itamet.</a></li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="footer-bottom d-flex text-center">
                    <div class="col-6"><p>Made with <i class="fa fa-keyboard-o"></i> and <i class="fa fa-hand-stop-o">.</i></p></div>
                    <div class="col-6"><h5>Designed by Le Thanh Long.</h5></div>
    <script>
        (function() {
            const btn = document.getElementById('themeToggle');
            function applyTheme(theme) {
                if (theme === 'light') {
                    document.body.classList.add('theme-light');
                    if (btn) btn.textContent = 'Dark';
                } else {
                    document.body.classList.remove('theme-light');
                    if (btn) btn.textContent = 'Light';
                }
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
    </script>

                </div>
            </div>
        </div>

    </div>
</body>
</html>
