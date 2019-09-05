<?php


namespace App\Lib;


class Helpers
{
    public static function toArray($data)
    {
        return json_decode(json_encode($data), 1);
    }
}
