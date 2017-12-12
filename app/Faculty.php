<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    protected $table = 'faculties';

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    /**
     * Get all teachers by relation faculty
     *
     * @return HasMany
     */
    public function teachers(): HasMany
    {
        return $this->hasMany(TeacherFaculty::class, 'faculty_id', 'id')->with('teacher');
    }
}
