<?php

namespace App\Http\Controllers;

use App\Http\Requests\ObjectRequest;
use App\Object;
use Illuminate\Http\{Request, JsonResponse};
use Illuminate\Support\Facades\Auth;

class ObjectController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:admin')->only(['create', 'delete']);
        $this->middleware('role:admin|object-owner')->only(['one', 'update']);
    }

    /**
     * Get list of subjects
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        // TODO: Temporary
        return Object::where('name', 'like', '%' . $request->search . '%')->get();
    }

    /**
     * Get one subject
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function one(Request $request)
    {
        $object = Object::findOrFail($request->id);


        if ($object && (Auth::user()->object_id === $object->id)) {
            return $object;
        }

        return JsonResponse::fromJsonString('You don\'t have permissions for this object', 403);
    }

    /**
     * Create new subject
     *
     * @param ObjectRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(ObjectRequest $request)
    {
        $object = new Object();

        $object->name = $request->name;
        $object->type_id = $request->type;
        $object->image = $request->image ?: 'no-image.png';
        $object->timestamps;

        if($object->save()) {
            return JsonResponse::fromJsonString('Object successful saved');
        }

        return JsonResponse::fromJsonString('Something was wrong', 400);
    }

    /**
     * Update existing subject by id
     *
     * @param ObjectRequest $request
     *
     * @return JsonResponse
     */
    public function update(ObjectRequest $request)
    {
        $object = Object::find($request->id);

        if(!$object) {
            return JsonResponse::fromJsonString('Object not found', 404);
        }

        if((Auth::user()->object_id !== $object->id)) {
            return JsonResponse::fromJsonString('You don\'t have permissions for this object', 403);
        }

        $object->name = $request->name;
        $object->type_id = $request->type;
        $object->image = $request->image ?: 'no-image.png';
        $object->timestamps;

        if($object->save()) {
            return JsonResponse::fromJsonString('Object successful saved');
        }

        return JsonResponse::fromJsonString('Something was wrong', 400);
    }

    /**
     * Delete subject by id
     *
     * @param  Request $request
     */
    public function delete(Request $request)
    {
        // TODO: Implement delete() method.
    }
}