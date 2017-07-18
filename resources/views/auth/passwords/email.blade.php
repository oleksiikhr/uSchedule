@extends('layouts.app')

@section('title', 'Відновлення паролю')

@section('content')

    <email-form csrf="{{ csrf_token() }}"
                old-email="{{ old('email') }}"
                error-email="{{ $errors->first('email') }}"
                link="{{ route('password.email') }}"
                status="{{ session('status') }}"
    ></email-form>

@endsection
