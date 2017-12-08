<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Teacher extends Model
{
    protected $table = 'teachers';

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
