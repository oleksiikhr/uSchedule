<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\ObjectModel::class, function (Faker\Generator $faker) {
    $type = \App\ObjectType::inRandomOrder()->first();

    return [
        'name' => mb_substr($faker->company, 0, 100),
        'slug' => lcfirst($faker->unique()->firstName),
        'type_id' => $type->id,
        'image' => null,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});

$factory->define(App\Faculty::class, function (Faker\Generator $faker) {
   $object = \App\ObjectModel::inRandomOrder()->first();

   return [
       'object_id' => $object->id,
       'name' => mb_substr($faker->unique()->company, 0, 191),
       'description' => $faker->realText(),
       'created_at' => $faker->date('Y-m-d H:i:s'),
       'updated_at' => $faker->date('Y-m-d H:i:s')
   ];
});

$factory->define(App\Group::class, function (Faker\Generator $faker) {
    $faculty = \App\Faculty::inRandomOrder()->first();

    return [
        'faculty_id' => $faculty->id,
        'course' => mt_rand(1, 4),
        'name' => mb_substr($faker->unique()->company, 0, 191),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});

$factory->define(App\Teacher::class, function (Faker\Generator $faker) {
    $object = \App\ObjectModel::inRandomOrder()->first();

    return [
        'object_id' => $object->id,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_name' => $faker->lastName,
        'academic_title' => $faker->title,
        'image' => null,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});

$factory->define(App\Subject::class, function (Faker\Generator $faker) {
    $object = \App\ObjectModel::inRandomOrder()->first();

    return [
        'object_id' => $object->id,
        'title' => $faker->jobTitle,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});

$factory->define(App\SubjectFaculty::class, function (Faker\Generator $faker) {
    $subject = \App\Subject::inRandomOrder()->first();
    $faculty = \App\Faculty::where('object_id', '=', $subject->object_id)->inRandomOrder()->first();

    return [
        'subject_id' => $subject->id,
        'faculty_id' => $faculty->id,
    ];
});

$factory->define(App\TeacherFaculty::class, function(Faker\Generator $faker) {
    $teacher = \App\Teacher::inRandomOrder()->first();
    $faculty = \App\Faculty::where('object_id', '=', $teacher->object_id)->inRandomOrder()->first();

    return [
        'teacher_id' => $teacher->id,
        'faculty_id' => $faculty->id,
    ];
});