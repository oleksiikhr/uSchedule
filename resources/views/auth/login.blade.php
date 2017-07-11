@extends('layouts.app')

@section('title')Авторизація@endsection

@section('content')

    <login csrf="{{ csrf_token() }}"
           errors="{{ json_encode($errors) }}"
           old-email="{{ old('email') }}"
           old-remember="{{ old('remember') }}"
    ></login>

@endsection
