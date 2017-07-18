@extends('layouts.app')

@section('title')Авторизація@endsection

@section('content')

    <login-form csrf="{{ csrf_token() }}"
                has-error="{{ count($errors) > 0 }}"
                old-email="{{ old('email') }}"
                old-remember="{{ old('remember') }}"
                link="{{ route('login') }}"
                forgot-link="{{ route('password.request') }}"
    ></login-form>

@endsection
