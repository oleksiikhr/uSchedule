<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherRequest;
use App\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        // TODO Validate $request

        $teacher = new Teacher();
        $teachers = $teacher->getTeachers($request->order, $request->search, $request->count);

        return response()->json(['status' => 'ok', 'teachers' => $teachers]);
    }

    public function show(Request $request)
    {
        return response()->json(['status' => 'ok', 'data' => Teacher::getTeacherById($request->id)]);
    }

    public function store(StoreTeacherRequest $request)
    {
        $teacher = new Teacher([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'academic_title' => $request->academic_title
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('image')->store(
                'teachers',  'public'
            );

            $teacher->image = $path;
        }

        if ($teacher->save()) {
            return response()->json(['status' => 'ok', 'item' => $teacher]);
        }

        return response()->json(['status' => 'error']);
    }

    public function update(StoreTeacherRequest $request)
    {
        $teacher = Teacher::getTeacherById($request->id);
        $teacher->first_name = $request->first_name;
        $teacher->last_name = $request->last_name;
        $teacher->middle_name = $request->middle_name;
        $teacher->academic_title = $request->has('academic_title')
            ? $request->academic_title
            : $teacher->academic_title;

        if ($request->hasFile('file')) {
            $path = $request->file('image')->store(
                'teachers', 'public'
            );

            $teacher->image = $path;
        }

        if ($teacher->save()) {
            return response()->json(['status' => 'ok', 'item' => $teacher]);
        }

        return response()->json(['status' => 'error']);

    }

    public function destroy(Request $request)
    {
        $teacher = Teacher::getTeacherById($request->id);

        if ($teacher->delete()) {
            return response()->json(['status' => 'ok']);
        }

        return response()->json(['status' => 'error']);
    }
}
