@extends('layouts.app')

@section('title')Авторизація@endsection

@section('content')

    <login csrf="{{ csrf_token() }}"
           has-error="{{ count($errors) > 0 }}"
           old-email="{{ old('email') }}"
           old-remember="{{ old('remember') }}"
    ></login>

@endsection
