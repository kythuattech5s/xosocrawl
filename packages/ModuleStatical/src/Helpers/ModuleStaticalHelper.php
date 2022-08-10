<?php
namespace ModuleStatical\Helpers;

class ModuleStaticalHelper
{
    public static function timeToFullcode($time)
    {
        return $time->year.$time->format('m').$time->format('d');
    }
    public static function extractJson($json,$isArray = true,$def = []) {
        json_decode($json);
        if (json_last_error() != JSON_ERROR_NONE) return $def;
        return $isArray ? json_decode($json,true):json_decode($json);
    }
    public static function parseStringToTime($timeString)
    {
        return now()->createFromTimestamp(strtotime($timeString));
    }
}