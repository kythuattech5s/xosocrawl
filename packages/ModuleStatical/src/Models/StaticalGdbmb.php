<?php
namespace ModuleStatical\Models;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class StaticalGdbmb extends BaseModel
{
    use HasFactory;
    public static function checkExist($type,$time,$key = null)
    {
        $oldItem = self::where('type',$type)
                    ->where('day',$time->day)
                    ->where('month',$time->month)
                    ->where('year',$time->year)
                    ->when($key,function($q) use ($key) {
                        $q->where('key',$key);
                    })
                    ->first();
        return isset($oldItem);
    }
    public static function getItemData($type,$time,$key = null)
    {
        $oldItem = self::where('type',$type)
                    ->where('day',$time->day)
                    ->where('month',$time->month)
                    ->where('year',$time->year)
                    ->when($key,function($q) use ($key) {
                        $q->where('key',$key);
                    })
                    ->first();
        return $oldItem;
    }
}
