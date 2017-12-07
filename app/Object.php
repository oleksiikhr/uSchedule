<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

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

    public function objectType()
    {
        return $this->hasOne('App\ObjectType', 'type_id');
    }

    public function object()
    {
        return $this->hasMany(Object::class);
    }
}
