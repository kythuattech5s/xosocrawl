<?php
namespace basiccomment\comment\Helpers;
use \Str;
class CommentHelper
{
    public static function generateHash($key)
    {
        $hash = $key.rand(100,999);
    	$hash = base64_encode($hash);
        $hash = base64_encode($hash.Str::random(30));
        $hash = base64_encode(Str::random(30).$hash);
    	return $hash;
    }
    public static function unHash($hash)
    {
        $key = base64_decode($hash);
        $key = Str::substr($key,30,Str::length($key));
        $key = base64_decode($key);
        $key = Str::substr($key,0,Str::length($key) - 30);
        $key = base64_decode($key);
        $key = Str::substr($key,0,Str::length($key) - 3);
        return $key;
    }
    public static function showTime($time,$isDateTime = false , $format = "H:i d/m/Y")
    {
        if($isDateTime){
            $date = new \DateTime($time);
            return $date->format($format);
        }
        $updateTime = strtotime($time);
        $now = strtotime(date("Y-m-d H:i:s"));
        $time = $updateTime - $now;
        $day = floor($time / (24 * 60 * 60));
        $hour = floor($time / (60 * 60));
        $minutes = floor($time / 60);
        $second = floor($time);
        $isReverse = false;
        if ($time < 0) {
            $isReverse = true;
            $time = $now - $updateTime;
        }
        if ($time >= (2 * 24 * 60 * 60)) {
            $value = date("H:i d/m/Y", $updateTime);
        } elseif ($time >= (24 * 60 * 60)) {
            $value = $day . " ngày nữa";
        } elseif ($time >= (60 * 60)) {
            $value = $hour . " giờ nữa";
        } elseif ($time >= 60) {
            $value = $minutes . " phút nữa";
        } else {
            if ($second == 0) {
                $value = "vừa xong";
            }else {
                $value = $second . " giây nữa";
            }
        }
        if ($isReverse) {
            $value = str_replace(['-', 'nữa'], ['', 'trước'], $value);
        }
        return $value;
    }
    public static function extractJson($json,$isArray = true,$def = []) {
        json_decode($json);
        if (json_last_error() != JSON_ERROR_NONE) return $def;
        return $isArray ? json_decode($json,true):json_decode($json);
    }
}
