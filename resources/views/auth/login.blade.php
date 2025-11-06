@extends('layout')
@section('content')
    @include('auth.auth-forms', ['initialTab' => 'login'])
@endsection
