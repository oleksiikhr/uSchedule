<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Teacher extends Model
{
    protected $table = 'teachers';

    public function faculty()
    {
        return $this->belongsToMany(Faculty::class);
    }

    public function lesson()
    {
        return $this->hasMany(LessonSub::class);
    }

    /**
     * Get all teachers by object
     *
     * @param int $objectId
     *
     * @return Collection
     */
    public function getTeachersByObject(int $objectId): Collection
    {
        return self::where('object_id', $objectId)->orderBy('id')->get();
    }
}
