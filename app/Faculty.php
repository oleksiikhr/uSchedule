<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Expression;

class Faculty extends Model
{
    protected $table = 'faculties';

    /**
     * Get all subjects by faculty
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjects(): HasMany
    {
        return $this->hasMany(SubjectFaculty::class, 'faculty_id', 'id')->with('subject');
    }
}
