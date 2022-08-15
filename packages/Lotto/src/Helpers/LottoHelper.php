<?php

namespace Lotto\Helpers;

use Illuminate\Support\Collection;
use Lotto\Models\LottoItem;

class LottoHelper
{
    public static function getCurrentDateOfWeek($date = null)
    {
        $date = isset($date) ? $date : now();
        $currentDayOfWeek = $date->dayOfWeek;
        $currentDayOfWeek = $currentDayOfWeek == 0 ? $currentDayOfWeek + 8 : $currentDayOfWeek + 1;
        return $currentDayOfWeek;
    }
    public static function checkUrlExists($url): bool
    {
        $headers = @get_headers($url);
        if (!is_array($headers)) {
            return false;
        }
        return stripos($headers[0], "200 OK") ? true : false;
    }
    public static function requestUrl($url, $type = 'GET', $data = null, $headers = []): string
    {
        $curl = curl_init();
        $params = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $type,
            CURLOPT_FOLLOWLOCATION => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        );
        if ($type == 'POST' && is_string($data)) {
            $params[CURLOPT_POSTFIELDS] = $data;
        }
        if ($type == 'POST' && is_array($data)) {
            $params[CURLOPT_POSTFIELDS] = http_build_query($data);
        }
        if ($type == 'GET' && is_array($data)) {
            $params[CURLOPT_URL] = $url . '?' . http_build_query($data);
        }
        if ($headers) {
            $params[CURLOPT_HTTPHEADER] = $headers;
        }
        curl_setopt_array($curl, $params);
        $res = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if (!empty($err)) {
            return $err;
        }
        return $res;
    }
}
