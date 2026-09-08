@extends('layout')
@section('title',$title.' - movieON')
@section('content')<div class="container py-4 text-white"><h1>{{ $title }}</h1><div class="row">@each('partials.movie-card',$movies,'movie','partials.empty')</div>{{ $movies->links() }}</div>@endsection
