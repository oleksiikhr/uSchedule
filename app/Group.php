<?php

namespace App;

use Illuminate\Database\Eloquent\{Model, Collection};
use Illuminate\Database\Eloquent\Relations\Relation;

class Group extends Model
{
    protected $table = 'groups';

    /**
     * Get faculty info by group
     *
     * @return Relation
     */
    public function faculty(): Relation
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'id');
    }

    /**
     * Get captain info by group
     *
     * @return Relation
     */
    public function captain(): Relation
    {
        return $this->belongsTo(User::class, 'captain_id', 'id');
    }

    /**
     * Get all groups by faculty
     *
     * @param int $facultyId
     *
     * @return Collection
     */
    public function getGroupsByFaculty(int $facultyId): Collection
    {
        return self::with('faculty')->where('faculty_id', $facultyId)->get();
    }
}
