<?php

namespace vanhenry\helpers\helpers;

class JsonHelper
{

    public static function echoJson($code, $message, $noti = 1)
    {
        $obj = new \stdClass();
        $obj->code = $code;
        $obj->message = $message;
        $obj->noti = $noti;
        return json_encode($obj);
    }

}
