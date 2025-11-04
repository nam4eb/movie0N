<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('is_published', true)
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('pages.news.index', compact('news'));
    }

    public function show(string $slug)
    {
        $article = News::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('pages.news.show', compact('article'));
    }
}

