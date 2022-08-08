<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class TestSpinViettlotData extends BaseModel
{
    use HasFactory;
    public static function randomData($type){
        switch ($type) {
            case 'mega':
                $ret = '';
                for ($i=0; $i < 6; $i++) { 
                    $ret.= self::generateRandomStringNumber(2).',';
                }
                return trim($ret,',');
                break;
            case 'power':
                $ret = '';
                for ($i=0; $i < 7; $i++) { 
                    $ret.= self::generateRandomStringNumber(2).',';
                }
                return trim($ret,',');
                break;
            default:
                return '';
                break;
        }
    }
    public static function getDataTestSpin($type,$time)
    {
        $oldItem = self::where('test_spin_viettlot_type',$type)->where('day',$time->day)
                                                            ->where('month',$time->month)
                                                            ->where('year',$time->year)
                                                            ->first();
        if (!isset($oldItem)) {
            $newItem = new TestSpinViettlotData;
            $newItem->day = $time->day;
            $newItem->month = $time->month;
            $newItem->year = $time->year;
            $newItem->test_spin_viettlot_type = $type;
            $newItem->data = self::randomData($type);
            $newItem->save();
            return $newItem->buildData();
        }
        return $oldItem->buildData();
    }
    public static function generateRandomStringNumber($length = 10) {
        $randomStringNumber = '';
        for ($i = 0; $i < $length; $i++) {
            $randomStringNumber .= rand(0,9);
        }
        return $randomStringNumber;
    }
    public function buildData()
    {
       return "'".implode("','",explode(',',$this->data))."'";
    }
}
