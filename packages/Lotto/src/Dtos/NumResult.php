<?php

namespace Lotto\Dtos;

use Lotto\Models\LottoResultDetail;

class NumResult
{
    protected $strId;
    protected $DB = [];
    protected $dauDB = [];
    protected $duoiDB = [];
    protected $tongDB = [];

    protected $lotto = [];
    protected $dauLotto = [];
    protected $duoiLotto = [];
    protected $tongLotto = [];
    public function __construct($lottoCategory, $createdAt, $numOfDay)
    {
        $records = $lottoCategory->lottoRecords()->select('id')->where('created_at', '>', $createdAt)->orderBy('created_at', 'desc')->limit($numOfDay)->get();
        $strId = $records->implode('id', ',');

        $this->strId = $strId;
        for ($i = 0; $i < 10; $i++) {
            $this->dauDB[$i] = 0;
            $this->duoiDB[$i] = 0;
            $this->tongDB[$i] = 0;
            $this->dauLotto[$i] = 0;
            $this->duoiLotto[$i] = 0;
            $this->tongLotto[$i] = 0;
        }
    }
    public function analytic()
    {
        $details = LottoResultDetail::select('number', 'no_prize', 'lotto_record_id')->whereIn('lotto_record_id', explode(',', $this->strId))->orderBy('created_at', 'desc')->get();

        foreach ($details as $key => $detail) {
            $twoLastCharacter = substr($detail->number, -2);
            if ($detail->no_prize == 0) {
                $this->analyticDB($twoLastCharacter);
            }
            $this->analyticLoto($twoLastCharacter);
        }
    }
    protected function analyticDB($twoLastCharacter)
    {
        $this->updateAnalytic($twoLastCharacter, $this->DB);
        $this->updateAnalyticDau($twoLastCharacter, $this->dauDB);
        $this->updateAnalyticDuoi($twoLastCharacter, $this->duoiDB);
        $this->updateAnalyticTong($twoLastCharacter, $this->tongDB);
    }
    protected function analyticLoto($twoLastCharacter)
    {
        $this->updateAnalytic($twoLastCharacter, $this->lotto);
        $this->updateAnalyticDau($twoLastCharacter, $this->dauLotto);
        $this->updateAnalyticDuoi($twoLastCharacter, $this->duoiLotto);
        $this->updateAnalyticTong($twoLastCharacter, $this->tongLotto);
    }
    protected function updateAnalytic($twoLastCharacter, &$results)
    {
        if (!array_key_exists($twoLastCharacter, $results)) {
            $results[$twoLastCharacter]['count'] = 0;
            $results[$twoLastCharacter]['number'] = $twoLastCharacter;
        }

        $results[$twoLastCharacter]['count']++;
    }
    protected function updateAnalyticDau($twoLastCharacter, &$results)
    {
        $firstDB = substr($twoLastCharacter, 0, 1);
        if (!array_key_exists($firstDB, $results)) {
            $results[$firstDB] = 0;
        }

        $results[$firstDB]++;
    }
    protected function updateAnalyticDuoi($twoLastCharacter, &$results)
    {
        $lastDB = substr($twoLastCharacter, -1);
        if (!array_key_exists($lastDB, $results)) {
            $results[$lastDB] = 0;
        }
        $results[$lastDB]++;
    }
    protected function updateAnalyticTong($twoLastCharacter, &$results)
    {
        $firstDB = substr($twoLastCharacter, 0, 1);
        $lastDB = substr($twoLastCharacter, -1);
        $tong = (int)$firstDB + (int)$lastDB;
        $tong = $tong % 10;
        if (!array_key_exists($tong, $results)) {
            $results[$tong] = 0;
        }
        $results[$tong]++;
    }

    /**
     * Get the value of DB
     *
     * @return  mixed
     */
    public function getDB()
    {
        uasort($this->DB, function ($a, $b) {
            $difcount = $b['count'] - $a['count'];
            if ($difcount == 0) {
                return $a['number'] - $b['number'];
            }
            return $difcount;
        });
        return $this->DB;
    }

    /**
     * Get the value of dauDB
     *
     * @return  mixed
     */
    public function getDauDB()
    {
        return $this->dauDB;
    }

    /**
     * Get the value of duoiDB
     *
     * @return  mixed
     */
    public function getDuoiDB()
    {
        return $this->duoiDB;
    }

    /**
     * Get the value of tongDB
     *
     * @return  mixed
     */
    public function getTongDB()
    {
        return $this->tongDB;
    }

    /**
     * Get the value of lotto
     *
     * @return  mixed
     */
    public function getLotto()
    {
        uasort($this->lotto, function ($a, $b) {
            $difcount = $b['count'] - $a['count'];
            if ($difcount == 0) {
                return $a['number'] - $b['number'];
            }
            return $difcount;
        });
        return $this->lotto;
    }

    /**
     * Get the value of dauLotto
     *
     * @return  mixed
     */
    public function getDauLotto()
    {
        return $this->dauLotto;
    }

    /**
     * Get the value of duoiLotto
     *
     * @return  mixed
     */
    public function getDuoiLotto()
    {
        return $this->duoiLotto;
    }

    /**
     * Get the value of tongLotto
     *
     * @return  mixed
     */
    public function getTongLotto()
    {
        return $this->tongLotto;
    }
}
