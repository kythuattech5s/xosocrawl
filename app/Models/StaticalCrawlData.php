<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class StaticalCrawlData extends BaseModel
{
    use HasFactory;
    public static function checkExist($identify)
    {
        $oldItem = self::where('identify',$identify)->first();
        return isset($oldItem);
    }
    public static function getItem($identify)
    {
        $oldItem = self::where('identify',$identify)->first();
        return $oldItem;
    }
    public static function createItem($staticalCrawlId,$identify,$value,$time,$param = null)
    {
        $newItem = new StaticalCrawlData;
        $newItem->statical_craw_id = $staticalCrawlId;
        $newItem->identify = $identify;
        $newItem->day = $time->day;
        $newItem->month = $time->month;
        $newItem->year = $time->year;
        $newItem->value = $value;
        if (isset($param) && count($param) > 0) {
            $newItem->param = json_encode($param);
        }
        $newItem->save();
        return $newItem;
    }
}
