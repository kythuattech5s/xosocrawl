<?php

namespace Lotto\Dtos;

use Arr;
use Illuminate\Support\Collection;
use Lotto\Models\LottoRecord;

class LottoItemMnCollection
{
    protected $lottoItems = [];
    protected $lottoRecords;
    protected $lottoRecord;
    protected $transformResults = [];
    protected function __construct(Collection $lottoRecords)
    {
        $this->lottoRecords = $lottoRecords;
        $this->lottoRecord = $lottoRecords->first();
        $this->transfrom();
    }
    protected function transfrom()
    {
        if (count($this->transformResults) > 0) return $this->transformResults;
        $transformResults = [];
        foreach ($this->lottoRecords as $key => $lottoRecord) {
            $this->lottoItems[] = $lottoItem = $lottoRecord->lottoItem;
            $keyItem = $lottoItem->id;
            $lottoResultDetails = $lottoRecord->lottoResultDetails->groupBy('no_prize');
            $transformResults['-1'][$keyItem] = [
                'item' => $lottoItem,
            ];
            foreach ($lottoResultDetails as $keyDetail => $details) {
                $transformResults[$keyDetail][$keyItem] = [
                    'item' => $lottoItem,
                    'numbers' => $details
                ];
            }
        }
        return $this->transformResults = $transformResults;
    }
    public function headTail()
    {
        return new HeadTailMn($this->transformResults);
    }

    /**
     * Get the value of transformResults
     *
     * @return  mixed
     */
    public function getTransformResults()
    {
        return $this->transformResults;
    }
    public function prev($checkLottoItem = false, $dow = false)
    {
        $records = $this->lottoRecord->prev($checkLottoItem, $dow, 4);
        return static::createFromLottoRecords($records);
    }
    public static function createFromLottoRecords($lottoRecords)
    {
        $records = $lottoRecords->groupBy('fullcode');
        $listRecords = $records->first();
        foreach ($records as $tmp) {
            if (count($tmp) > count($listRecords)) {
                $listRecords = $tmp;
            }
        }
        return new LottoItemMnCollection($listRecords);
    }

    /**
     * Get the value of lottoRecord
     *
     * @return  mixed
     */
    public function getLottoRecord()
    {
        return $this->lottoRecord;
    }

    /**
     * Get the value of lottoItems
     *
     * @return  mixed
     */
    public function getLottoItems()
    {
        return collect($this->lottoItems);
    }
    public function countItems()
    {
        return count($this->lottoItems);
    }
}
