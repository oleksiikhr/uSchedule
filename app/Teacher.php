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
     * @param array $order
     * @param string $search
     * @param int $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getTeachers($order = [], $search = '', $perPage = self::PER_PAGE)
    {
        $query = self::query();

        if (! empty($search)) {
            $query->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('middle_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%');
        }

        if (! empty($order)) {
            $query->orderBy($order['column'], $order['type']);
        }

        return $query->paginate(!empty($perPage) ? (int)$perPage : self::PER_PAGE);
    }
}
