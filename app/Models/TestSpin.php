<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class TestSpin extends BaseModel
{
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(TestSpinCategory::class,'test_spin_category_id');
    }
    public static function buildDataSpinCate($testSpinCate,$listActiveTestSpinToday)
    {
        if ($testSpinCate->id == 1) {
            $dataSpin =TestSpinData::getOrCreateDataByCode('mien-bac',now());
            $dataRet = [];
            $dataRet['provinceCode'] = 'MB';
            $dataRet['provinceName'] = 'Miền Bắc';
            $dataRet['resultDate'] = now()->startOfDay()->timestamp;
            $dataRet['tuong_thuat'] = false;
            $dataRet['lotData'] = \Support::extractJson($dataSpin->data);
            return json_encode($dataRet);
        }
        $dataRet = [];
        foreach ($listActiveTestSpinToday as $itemActiveTestSpinToday) {
            array_push($dataRet,$itemActiveTestSpinToday->builDataSpin());
        }
        return json_encode($dataRet);
    }
    public function builDataSpin()
    {
        $dataSpin =TestSpinData::getOrCreateDataByTestSpin($this,now());
        $dataRet = [];
        if ($this->test_spin_category_id == 1) {
            $dataRet['provinceCode'] = 'MB';
        }else{
            $dataRet['provinceCode'] = \Str::upper($this->province_short_code);
        }
        $dataRet['provinceName'] = $this->province_name;
        $dataRet['resultDate'] = now()->startOfDay()->timestamp;
        $dataRet['tuong_thuat'] = false;
        $dataRet['lotData'] = \Support::extractJson($dataSpin->data);
        return $dataRet;
    }
}
