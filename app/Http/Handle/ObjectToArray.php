<?php

namespace App\Http\Handle;

class ObjectToArray
{
    static function handle(object $object)
    {
        $array = array();

        $stations = $object->Stations;

        foreach ($stations as $key => $station) {
            $array[$key] = $station;
        }

        return $array;
    }
}
