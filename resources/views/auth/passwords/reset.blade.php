@extends('layouts.app')

@section('title')Скидання пароля@endsection

@section('content')

    {{--TODO: No tested--}}

    <reset-form csrf="{{ csrf_token() }}"
                link="{{ route('password.request') }}"
                error="{{ $errors->first() }}"
                old-email="{{ old('email') }}"
                token="{{ $token }}"
                status="{{ session('status') }}"
    ></reset-form>

@endsection
