<?php

namespace App\Helpers;

use App\Helpers\Media;
use App\Models\Menu;
use Carbon\Carbon;
use Currency;

class Support
{
    public static function extractJson($json,$isArray = true,$def = []) {
        json_decode($json);
        if (json_last_error() != JSON_ERROR_NONE) return $def;
        return $isArray ? json_decode($json,true):json_decode($json);
    }
    public static function isDateTime($string, $format = 'Y-m-d H:i:s')
    {
        return \DateTime::createFromFormat($format, $string);
    }

    public static function showDateTime($string, $format = 'd/m/Y')
    {
        if (self::isDateTime($string)) {
            return Carbon::parse($string)->format($format);
        }
    }
    public static function format($date, $format = 'd/m/Y')
    {
        return $date->format($format);
    }
    public static function getDayOfWeek($date, $forceDate = -1)
    {
        if ($forceDate < 0) {
            $dow = $date->dayOfWeek;
        } else {
            $dow = $forceDate;
        }

        switch ($dow) {
            case 0:
                return 'Chủ Nhật';
            case 1:
                return 'Thứ 2';
            case 2:
                return 'Thứ 3';
            case 3:
                return 'Thứ 4';
            case 4:
                return 'Thứ 5';
            case 5:
                return 'Thứ 6';
            case 6:
                return 'Thứ 7';
        }
    }
    public static function getLottoDayOfWeek($date, $forceDate = -1)
    {
        if ($forceDate < 0) {
            $dow = $date->dayOfWeek;
        } else {
            $dow = $forceDate;
        }

        switch ($dow) {
            case 8:
                return 'Chủ Nhật';
            case 2:
                return 'Thứ 2';
            case 3:
                return 'Thứ 3';
            case 4:
                return 'Thứ 4';
            case 5:
                return 'Thứ 5';
            case 6:
                return 'Thứ 6';
            case 7:
                return 'Thứ 7';
        }
    }

    public static function show($object, $key, $def = '')
    {
        if (!is_object($object) && !is_array($object)) {
            return $def;
        }
        if (is_object($object)) {
            $value = isset($object->$key) ? $object->$key : $def;
        } else {
            $value = isset($object[$key]) ? $object[$key] : $def;
        }
        switch ($key) {
            case 'price':
            case 'price_old':
            case 'starting_price':
            case 'origin_price':
            case 'price_step':
            case 'subtotal':
            case 'priceTotal':
                return Currency::showMoney($value);
                break;
            case 'slug':
                return $value;
                break;
            case 'link':
                return self::language($value);
                break;
            default:
                return $value;
                break;
        }
    }

    public static function language($value)
    {
        if (\App::getLocale() == 'en') {
            return '/en' . '/' . $value;
        } else {
            return $value;
        }
    }

    public static function uploadImg($inputName, $saveFrom, $checkFileExist)
    {
        if (!request()->hasFile($inputName)) {
            return '';
        }
        $images = request()->file($inputName);
        if ($images == null) {
            return '';
        }
        if (is_array($images)) {
            $image = $images[0];
        } else {
            $image = $images;
        }
        $uploadRootDir = 'uploads';
        $uploadDir = $saveFrom;
        $pathRelative = $uploadRootDir . '/' . $uploadDir . '/';
        $pathAbsolute = public_path($pathRelative);
        $dirs = explode('/', $uploadDir);
        $parentId = 0;
        foreach ($dirs as $item) {
            $parentId = Media::createDir($uploadRootDir, $item, $pathRelative, $pathAbsolute, $parentId);
        }
        if (is_bool($parentId)) {
            return '';
        }
        $ext = $image->getClientOriginalExtension();
        $fileName = strtolower(\Str::random(5)) . '-' . time() . '.' . $ext;
        if (($checkFileExist && !file_exists($pathAbsolute . "/" . $image->getClientOriginalName())) || !$checkFileExist) {
            $image->move($pathAbsolute, $fileName);
        } else {
            $fileName = $image->getClientOriginalName();
        }
        $img_id = Media::insertImageMedia($uploadRootDir, $pathAbsolute, $pathRelative, $fileName, $parentId);
        // Thêm vào bảng cron
        \DB::table('custom_media_images')->insert([
            'name' => $pathRelative . $fileName,
            'media_id' => $img_id,
            'act' => 0,
        ]);
        return Media::img($img_id);
    }

    public static function uploadImgs($inputName, $saveFrom, $checkFileExist = false)
    {
        if (!request()->hasFile($inputName)) {
            return null;
        }
        $imgs = [];
        $images = request()->file($inputName);
        $uploadRootDir = 'public/uploads';
        $uploadDir = $saveFrom;
        $pathRelative = $uploadRootDir . '/' . $uploadDir . '/';
        $pathAbsolute = base_path($pathRelative);
        $parentId = Media::createDir($uploadRootDir, $uploadDir, $pathRelative, $pathAbsolute);
        if (is_bool($parentId)) {
            return '';
        }
        foreach ($images as $key => $image) {
            if ($image == null) {
                continue;
            }
            $ext = $image->getClientOriginalExtension();
            $fileName = strtolower(\Str::random(5)) . '-' . time() . '.' . $ext;
            if (($checkFileExist && !file_exists($pathAbsolute . "/" . $image->getClientOriginalName())) || !$checkFileExist) {
                $image->move($pathAbsolute, $fileName);
            } else {
                $fileName = $image->getClientOriginalName();
            }

            $img_id = Media::insertImageMedia($uploadRootDir, $pathAbsolute, $pathRelative, $fileName, $parentId);
            // Thêm vào bảng cron
            \DB::table('custom_media_images')->insert([
                'name' => $pathRelative . $fileName,
                'act' => 0,
                'media_id' => $img_id,
            ]);
            $imgs[] = $img_id;
        }
        return Media::libImg($imgs);
    }

    public static function getMenuRecursive($group = null, int $take = null)
    {
        $menus = Menu::where('menu_category_id', $group)->where('parent', 0)->act()->ord()->with('recursiveChilds');
        if ($take != null) {
            return $menus->take($take)->get();
        }
        return $menus->get();
    }

    public static function showMenuRecursive($menus)
    {
        if ($menus->count() > 0) {
            $addClass = '';
            if ($menus->count() > 10) {
                $addClass = 'big-menu';
            }
            echo '<ul class="' . $addClass . '">';
            foreach ($menus as $menu) {
                $active = url()->current() == url($menu->link) ? "active" : " ";
                echo '<li>';
                echo '<a href="' . $menu->link . '" title="' . \Support::show($menu, 'name') . '" class="' . $active . '" >';
                echo \Support::show($menu, 'name');
                echo '</a>';
                self::showMenuRecursive($menu->recursiveChilds);
                echo '</li>';
            }
            echo '</ul>';
        }
    }

    public static function isLightHouseSp()
    {
        $agent = request()->header('User-Agent');
        preg_match('/Lighthouse/i', $agent, $outs);
        return count($outs) > 0;
    }

    public static function asset($file)
    {
        $file_path = public_path($file);

        if (file_exists($file_path)) {
            return asset($file) . '?v=' . filemtime($file_path);
        } else {
            $context = stream_context_create( [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);
            $path = collect(get_headers(url($file)));

            $path = $path->first(function ($string) {
                return strpos($string, 'path-link') === 0;
            });
            if ($path) {
                $file_path = base_path() . str_replace('path-link: ', '', $path);
            }
            if (file_exists($file_path)) {
                return asset($file) . '?v=' . filemtime($file_path);
            } else {
                return asset($file) . '?v=2';
            }
        }
    }

    public static function numberFormat($number, $stringFormat = ',', $stringChange = '.')
    {
        if (is_null($number) || $number == '') {
            return 0;
        }
        return number_format($number, 0, $stringFormat, $stringChange);
    }
    public static function json(array $arr, int $status = -1)
    {
        if ($status != -1) {
            return response()->json($arr, $status);
        }
        return response()->json($arr);
    }
    public static function response(array $arr, int $status = -1)
    {
        if (request()->ajax()) {
            return self::json($arr, $status);
        } else {
            \Session::flash('typeNotify', $arr['code'] != 200 ? 'error' : 'success');
            \Session::flash('messageNotify', $arr['message']);
            return (!isset($arr['redirect']) ? redirect('/') : redirect($arr['redirect']));
        }
    }
}
