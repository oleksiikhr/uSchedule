<?php

use App\Day;
use App\User;
use App\Group;
use App\Column;
use App\Lesson;
use App\Teacher;
use App\Faculty;
use App\Subject;
use App\Schedule;
use App\LessonSub;
use Carbon\Carbon;
use App\LessonType;
use App\ObjectModel;
use App\ObjectLessonTime;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    private static $countTeacher = 30;
    private static $countSubject = 30;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        self::Object();
        self::Faculty();
        self::Subject();
        self::Teacher();
        self::Group();
        self::User();
        self::Schedule();
        self::Column();
        self::Day();
        self::Lesson();
        self::LessonType();
        self::LessonSub();
        self::LessonTime();
    }

    private static function Object()
    {
        ObjectModel::insert([
            'name' => 'Demo',
            'slug' => 'demo',
            'type_id' => 1,
            'image' => 'objects/demo/img/logo_200.png'
        ]);
    }

    private static function Subject()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < self::$countSubject; $i++) {
            Subject::insert([
                'object_id' => 1,
                'title' => $faker->jobTitle,
                'created_at' => $faker->date('Y-m-d H:i:s'),
                'updated_at' => $faker->date('Y-m-d H:i:s')
            ]);
        }
    }

    private static function Teacher()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < self::$countTeacher; $i++) {
            Teacher::insert([
                'object_id' => 1,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'middle_name' => $faker->lastName,
                'academic_title' => $faker->title,
                'created_at' => $faker->date('Y-m-d H:i:s'),
                'updated_at' => $faker->date('Y-m-d H:i:s')
            ]);
        }
    }

    private static function Faculty()
    {
        Faculty::insert([
            'object_id' => 1,
            'name' => 'ФОАІС',
            'description' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    private static function Group()
    {
        Group::insert([
            'faculty_id' => 1,
            'name' => 10,
            'course' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    private static function User()
    {
        User::insert([
            'email'      => 'admin@example.com',
            'password'   => bcrypt('admin123'),
            'object_id'  => 1,
            'group_id'   => 1,
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);
    }

    private static function Schedule()
    {
        Schedule::insert([
            'object_id' => 1,
            'faculty_id' => 1,
            'group_id' => 1,
            'daytime' => 1,
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);
    }

    private static function Column()
    {
        for ($i = 0; $i < 2; $i++) {
            Column::insert([
                'schedule_id' => 1,
                'name' => $i . ' неділя',
                'order' => $i,
            ]);
        }
    }

    // NOTE: Max 10
    private static function Day()
    {
        for ($i = 1; $i <= 2; $i++) {
            for ($j = 1; $j <= 5; $j++) {
                Day::insert([
                    'column_id' => $i,
                    'order' => $j
                ]);
            }
        }
    }

    // NOTE: Max 20
    private static function Lesson()
    {
        for ($i = 0; $i < 20; $i++) {
            Lesson::insert([
                'day_id' => mt_rand(1, 10),
                'subject_id' => mt_rand(1, self::$countSubject),
                'order' => mt_rand(0, 6),
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ]);
        }
    }

    private static function LessonType()
    {
        $longArr = ['Лекція', 'Практика', 'Лабораторна робота 1', 'Лабораторна робота 2'];
        $shortArr = ['Л', 'П', 'Лб1', 'Лб2'];

        for ($i = 0; $i < count($longArr); $i++) {
            LessonType::insert([
                'object_id' => 1,
                'long_name' => $longArr[$i],
                'short_name' => $shortArr[$i],
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ]);
        }
    }

    private static function LessonSub()
    {
        for ($i = 1; $i <= 20; $i++) {
            LessonSub::insert([
                'lesson_id' => $i,
                'teacher_id' => self::$countTeacher,
                'type_id' => mt_rand(1, 3),
                'cabinet' => mt_rand(1, 999) . chr(mt_rand(97,122)),
            ]);
        }
    }

    private static function LessonTime()
    {
        $start = ['8:20', '9:55', '11:50', '13:30', '15:00', '16:30', '18:00'];
        $end = ['9:40', '11:15', '13:10', '14:50', '16:20', '17:50', '19:20'];

        for ($i = 0; $i < count($start); $i++) {
            ObjectLessonTime::insert([
                'object_id' => 1,
                'lesson_num' => $i + 1,
                'start_time' => $start[$i],
                'end_time' => $end[$i],
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ]);
        }
    }
}
