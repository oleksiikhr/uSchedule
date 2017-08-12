@extends('layouts.app')

@section('title', 'Редагування розкладу')

@section('body-classes', 'body-edit')

@section('content')

    <edit in-schedule-days="{{ json_encode($scheduleDays) }}"
          in-schedule="{{ json_encode($schedule) }}"
          in-teachers="{{ json_encode($teachers) }}"
          in-subjects="{{ json_encode($subjects) }}"
          in-time="{{ json_encode($time) }}"
    ></edit>

@endsection
