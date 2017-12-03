<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Object::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'slug' => lcfirst($faker->unique()->firstName),
        'type_id' => $faker->numberBetween(1, 3),
        'image' => 'no-image.png',
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime()
    ];
});

$factory->define(App\Faculty::class, function (Faker\Generator $faker) {
   $object = \App\Object::inRandomOrder()->first();
   return [
       'object_id' => $object->id,
       'name' => $faker->unique()->company,
       'description' => $faker->realText(),
       'created_at' => $faker->dateTime(),
       'updated_at' => $faker->dateTime()
   ];
});

$factory->define(App\Group::class, function (Faker\Generator $faker) {
    $faculty = \App\Faculty::inRandomOrder()->first();

    return [
        'captain_id' => null,
        'faculty_id' => $faculty->id,
        'name' => $faker->unique()->company,
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime()
    ];
});

$factory->define(App\Teacher::class, function (Faker\Generator $faker) {
    $object = \App\Object::inRandomOrder()->first();

    return [
        'object_id' => $object->id,
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName,
        'middle_name' => $faker->company,
        'academic_title' => $faker->title,
        'image' => 'no-image.png',
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime()
    ];
});

$factory->define(App\Subject::class, function (Faker\Generator $faker) {
    $object = \App\Object::inRandomOrder()->first();

    return [
        'object_id' => $object->id,
        'title' => $faker->jobTitle,
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime()
    ];
});

$factory->define(App\SubjectFaculty::class, function (Faker\Generator $faker) {
    $subject = \App\Subject::inRandomOrder()->first();
    $faculty = \App\Faculty::inRandomOrder()->first();

    return [
        'subject_id' => $subject->id,
        'faculty_id' => $faculty->id,
    ];
});
