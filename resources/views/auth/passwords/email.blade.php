@extends('layouts.app')

@section('content')

    {{--TODO: Email Expected response code 250 but got code "530", with message "530 5.7.1 Authentication required--}}

    <email-form csrf="{{ csrf_token() }}"
                old-email="{{ old('email') }}"
                error-email="{{ $errors->first('email') }}"
                link="{{ route('password.email') }}"
                status="{{ session('status') }}"
    ></email-form>

@endsection
