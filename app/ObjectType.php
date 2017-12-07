<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class ObjectType extends Model
{
    use Sluggable;

    protected $table = 'objects_types';

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

    public function objects()
    {
        return $this->hasMany('App\Object', 'type_id', 'id');
    }
}
