<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Object extends Model
{
    use Sluggable;

    protected $table = 'objects';

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function objectType(): Relation
    {
        return $this->hasOne(ObjectType::class, 'id', 'type_id');
    }

    public function subjects(): Relation
    {
        return $this->hasMany(Subject::class, 'object_id', 'id');
    }
}
