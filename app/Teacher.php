<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    const PER_PAGE = 20;

    public $timestamps = false;

    protected $fillable = ['first_name', 'middle_name', 'last_name', 'image', 'academic_title'];

    public function subjects()
    {
        return $this->hasMany('App\TeacherSubject', 'id', 'teacher_id');
    }

    /**
     * Get teacher image or default,
     *
     * @return string
     */
    public function getImageAttribute () {
        if (! $this->attributes['image']) {
            return url('/') . '/images/avatar.png';
        }

        return $this->attributes['image'];
    }

    /**
     * Get teacher by id.
     *
     * @param $id
     *
     * @return mixed
     */
    public static function getTeacherById($id)
    {
        return self::findOrFail($id);
    }

    /**
     * Get all teachers (ordered, searchable).
     *
     * @param string|array $order
     * @param string $search
     * @param int $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getTeachers($order = '', $search = '', $perPage = self::PER_PAGE)
    {
        $query = self::query();

        if (! empty($search)) {
            $words = explode(' ', $search);
            foreach ($words as $word) {
                $query->where(function ($q) use ($word) {
                    $q->where('first_name', 'like', '%' . $word . '%')
                        ->orWhere('middle_name', 'like', '%' . $word . '%')
                        ->orWhere('last_name', 'like', '%' . $word . '%');
                });
            }
        }

        if (! empty($order)) {
            if (is_array($order)) {
                foreach ($order as $json) {
                    $item = json_decode($json);
                    $query->orderBy($item->column, $item->type);
                }
            } else {
                $item = json_decode($order);
                $query->orderBy($item->column, $item->type);
            }
        }

        return $query->paginate(!empty($perPage) ? (int)$perPage : self::PER_PAGE);
    }
}
