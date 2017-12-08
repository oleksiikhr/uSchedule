<?php

namespace App;

use Illuminate\Database\Eloquent\{Collection, Model};

class Subject extends Model
{
    protected $table = 'subjects';

    /**
     * Get all subjects by object
     *
     * @param int $objectId
     *
     * @return Collection
     */
    public function getSubjectsByObject(int $objectId): Collection
    {
        return self::where('object_id', $objectId)->get();
    }
}
