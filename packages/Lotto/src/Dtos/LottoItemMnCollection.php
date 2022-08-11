<?php

namespace Lotto\Dtos;

use Arr;
use Illuminate\Support\Collection;

class LottoItemMnCollection
{
    protected $lottoItems;
    protected $lottoRecord;
    protected $transformResults = [];
    public function __construct(Collection $lottoItems)
    {
        $this->lottoItems = $lottoItems;
        $this->transfromLottoItems();
    }
    public function transfromLottoItems()
    {
        if (count($this->transformResults) > 0) return $this->transformResults;
        $transformResults = [];
        foreach ($this->lottoItems as $keyItem => $lottoItem) {
            $lottoRecord = $lottoItem->lottoRecords()->orderBy('created_at', 'desc')->first();
            if (!$this->lottoRecord) {
                $this->lottoRecord = $lottoRecord;
            }
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
    public function prev()
    {
        $records = $this->lottoRecord->prev(false, false, 4);
        return static::createFromLottoRecords($records);
    }
    protected static function createFromLottoRecords($lottoRecords)
    {
        $records = $lottoRecords->groupBy('fullcode');
        $lottoRecord = $records->first();
        foreach ($records as $tmp) {
            if (count($tmp) > count($lottoRecord)) {
                $lottoRecord = $tmp;
            }
        }
        $lottoItems = [];
        foreach ($lottoRecord as $r) {
            $lottoItems[] = $r->lottoItem;
        }
        return new LottoItemMnCollection(collect($lottoItems));
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
}
