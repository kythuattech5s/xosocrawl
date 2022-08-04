<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class TestSpinData extends BaseModel
{
    use HasFactory;
    public static function getLotteDataMbFormat() {
        $ret = [
            1 => [
                'count' => 1,
                'number_length' => 5
            ],
            2 => [
                'count' => 2,
                'number_length' => 5
            ],
            3 => [
                'count' => 6,
                'number_length' => 5
            ],
            4 => [
                'count' => 4,
                'number_length' => 4
            ],
            5 => [
                'count' => 6,
                'number_length' => 4
            ],
            6 => [
                'count' => 3,
                'number_length' => 3
            ],
            7 => [
                'count' => 4,
                'number_length' => 2
            ]
        ];
        return $ret;
    }
    public static function getLotteDataMnFormat() {
        $ret = [
            1 => [
                'count' => 1,
                'number_length' => 5
            ],
            2 => [
                'count' => 1,
                'number_length' => 5
            ],
            3 => [
                'count' => 2,
                'number_length' => 5
            ],
            4 => [
                'count' => 7,
                'number_length' => 5
            ],
            5 => [
                'count' => 1,
                'number_length' => 4
            ],
            6 => [
                'count' => 3,
                'number_length' => 4
            ],
            7 => [
                'count' => 1,
                'number_length' => 3
            ],
            8 => [
                'count' => 1,
                'number_length' => 2
            ]
        ];
        return $ret;
    }
    public static function getOrCreateDataByCode($provinceCode,$time){
        $oldItem = self::where('province_code',$provinceCode)->where('day',$time->day)
                                                            ->where('month',$time->month)
                                                            ->where('year',$time->year)
                                                            ->first();
        if (!isset($oldItem)) {
            $newItem = new TestSpinData;
            $newItem->test_spin_id = 0;
            $newItem->day = $time->day;
            $newItem->month = $time->month;
            $newItem->year = $time->year;
            $newItem->province_code = $provinceCode;
            $newItem->data = json_encode(self::randomDataMb());
            $newItem->save();
            return $newItem;
        }
        return $oldItem;
    }
    public static function getOrCreateDataByTestSpin($testSpin,$time){
        $oldItem = self::where('test_spin_id',$testSpin->id)->where('day',$time->day)
                                                            ->where('month',$time->month)
                                                            ->where('year',$time->year)
                                                            ->first();
        if (!isset($oldItem)) {
            $newItem = new TestSpinData;
            $newItem->test_spin_id = $testSpin->id;
            $newItem->day = $time->day;
            $newItem->month = $time->month;
            $newItem->year = $time->year;
            $newItem->province_code = $testSpin->province_code;
            $newItem->data = $testSpin->test_spin_category_id == 1 ? json_encode(self::randomDataMb()):json_encode(self::randomDataMn());
            $newItem->save();
            return $newItem;
        }
        return $oldItem;
    }
    public static function randomDataMb(){
        $data['DB'] = [self::generateRandomStringNumber(5)];
        $data['MaDb'] = [];
        for ($i=0; $i < 6; $i++) { 
            array_push($data['MaDb'],self::generateRandomStringNumber(1).\Str::upper(self::generateRandomString(2)));
        }
        foreach (self::getLotteDataMbFormat() as $key => $itemLotteDataFormat) {
            $data[$key] = [];
            for ($i=0; $i < $itemLotteDataFormat['count']; $i++) { 
                array_push($data[$key],self::generateRandomStringNumber($itemLotteDataFormat['number_length']));
            }
        }
        return $data;
    }
    public static function randomDataMn(){
        $data['DB'] = [self::generateRandomStringNumber(6)];
        foreach (self::getLotteDataMnFormat() as $key => $itemLotteDataFormat) {
            $data[$key] = [];
            for ($i=0; $i < $itemLotteDataFormat['count']; $i++) { 
                array_push($data[$key],self::generateRandomStringNumber($itemLotteDataFormat['number_length']));
            }
        }
        return $data;
    }
    
    public static function generateRandomString($length = 10) {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public static function generateRandomStringNumber($length = 10) {
        $randomStringNumber = '';
        for ($i = 0; $i < $length; $i++) {
            $randomStringNumber .= rand(0,9);
        }
        return $randomStringNumber;
    }
}
