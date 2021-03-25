<?php

namespace App\Helpers;

class JsonHelper
{
    /**
     * Return an encoded Json Response.
     *
     * @param   object $objects
     * @return \Illuminate\Http\JsonResponse
     */
    public function encodedJson(array $objects)
    {
        return response()->json($objects, 200);
    }

    /**
     * Return an extended encoded Json Response based in Key.
     *
     * @param   string $key
     * @param   object $objects
     * @return \Illuminate\Http\JsonResponse
     */
    public function extendedJson(string $key, object $objects)
    {
        $collection = [];
        foreach ($objects as $object) {
            $collection += ($object->$key) ? [$object->$key => $object] : ['Response' => 'Invalid index Key.'];
        }
        return $collection ? response()->json($collection, 200) : response()->json($collection, 404);
    }
}
