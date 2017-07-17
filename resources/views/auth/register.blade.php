@extends('layouts.app')

@section('title')Реєстрація@endsection

@section('content')

    <register-form csrf="{{ csrf_token() }}"
                   error="{{ $errors->first() }}"
                   link="{{ route('register') }}"
    ></register-form>

@endsection
