@extends('layouts.app')

@section('title', 'Редагування розкладу')

@section('body-classes', 'body-edit')

@section('content')

    <edit :schedule-days="{{ json_encode($scheduleDays) }}"
          :schedule="{{ json_encode($schedule) }}"
          :teachers="{{ json_encode($teachers) }}"
          :subjects="{{ json_encode($subjects) }}"
          :time="{{ json_encode($time) }}"
          :days-week="{{ json_encode($daysWeek) }}"
          :types="{{ json_encode($types) }}"
    ></edit>

@endsection
