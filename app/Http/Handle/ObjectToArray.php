<?php

namespace App\Http\Handle;

class ObjectToArray
{
    static function handle(string $resource, object $object)
    {
        $array = array();

        $stations = $object->$resource;

        foreach ($stations as $key => $station) {
            $array[$key] = $station;
        }

        return $array;
    }
}
