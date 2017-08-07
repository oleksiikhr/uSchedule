@extends('layouts.app')

@section('title', 'Редагування розкладу')

@section('body-classes', 'body-edit')

@section('content')

    <edit faculty="{{ $schedule->faculty_id }}"
          course="{{ $schedule->course }}"
          in-schedule-days="{{ $scheduleDays }}"
    ></edit>

@endsection
