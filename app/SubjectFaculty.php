<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SubjectFaculty extends Model
{
    protected $table = 'subjects_faculties';

    public $timestamps = false;

    /**
     * Get subject info
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subject(): HasOne
    {
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }
}
