<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cache;
use DB;
use FCHelper;
class Language extends Model
{
    use HasFactory;
    public static function getAll(){
    	if (!Cache::has("language"))
		{
			$cl= DB::table('languages')->where(array('act'=>1))->get();
			$ret = array();
			foreach ($cl as $key => $value) {
				$ret[$value->keyword] = $value;
			}
			\Cache::put('language', $ret, 86400);
		}
		return Cache::get("language");
    }
    public static function get($keyword)
    {
    	$ret = self::getAll();
    	$locale = \App::getLocale();
    	if (!isset($ret[$keyword])) {
    		return $keyword;
    	}
    	return FCHelper::er($ret[$keyword], $locale.'_value');
    }
}
