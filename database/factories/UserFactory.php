<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Faculty::class, function (Faker\Generator $faker){
   return [
       'title' => $faker->unique()->company,
       'slug' => lcfirst($faker->unique()->firstName)
   ];
});

$factory->define(App\Group::class, function (Faker\Generator $faker){
    $faculty = \App\Faculty::inRandomOrder()->first();

    return [
        'course' => $faker->numberBetween(1, 5),
        'faculty_id' => $faculty->id
    ];
});

$factory->define(App\Teacher::class, function (Faker\Generator $faker){
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_name' => $faker->title
    ];
});

$factory->define(App\Subject::class, function (Faker\Generator $faker){
    $faculty = \App\Faculty::inRandomOrder()->first();

    return [
        'title' => $faker->jobTitle,
        'course' => $faker->numberBetween(1, 5),
        'faculty_id' => $faculty->id,
        'type' => mt_rand(1, 2)
    ];
});

// Only for schedule_id = 1
$factory->define(App\ScheduleDay::class, function (Faker\Generator $faker) {
    $subject = \App\Subject::inRandomOrder()->first();

    return [
        'schedule_id' => 1,
        'subject_id' => $subject->id,
        'day' => mt_rand(0, 5),
        'week' => mt_rand(0, 1),
        'order' => mt_rand(0, 6),
        'room' => mt_rand(1, 500) . (mt_rand(0, 1) == 0 ? chr(mt_rand(65, 90)) : ''),
        'type' => mt_rand(0, 3),
        'is_empty' => mt_rand(0, 1),
    ];
});

try
{
    $factory->define(App\ScheduleDayTeacher::class, function (Faker\Generator $faker) {
        $scheduleDay = \App\ScheduleDay::inRandomOrder()->first();
        $teacher = \App\Teacher::inRandomOrder()->first();

        return [
            'schedule_day_id' => $scheduleDay->id,
            'teacher_id' => $teacher->id,
        ];
    });
} catch (Exception $e) {}
