<?php
namespace ModuleStatical\TrungNam;
class ModuleStaticalTrungNam
{
    public static function getTime(){
        $time = now()->subDays(1);
        if (now()->hour >= 17 && now()->minute >= 33) {
            $time = now();
        }
        return $time;
    }
}