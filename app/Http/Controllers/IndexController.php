<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function home(){
        return view('pages.home');
    }

    public function movieDetail(){
        return view('pages.movie-detail');
    }

    public function watchMovie(){
        return view('pages.watch-movie');
    }
}
