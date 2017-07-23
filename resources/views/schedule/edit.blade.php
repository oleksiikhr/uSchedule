@extends('layouts.app')

@section('title', 'Редагування розкладу')

@section('content')

    <edit faculty="{{ $schedule->faculty_id  }}" course="{{ $schedule->course  }}"></edit>

@endsection