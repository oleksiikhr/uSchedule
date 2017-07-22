@extends('layouts.app')

@section('title', 'Редагування розкладу')

@section('content')

    <div class="container">
        <edit faculty="{{ $schedule->faculty_id  }}" course="{{ $schedule->course  }}"></edit>
    </div>

@endsection