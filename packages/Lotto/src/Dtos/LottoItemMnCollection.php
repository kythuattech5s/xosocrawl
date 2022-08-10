<?php

namespace Lotto\Dtos;

use Arr;
use Illuminate\Support\Collection;

class LottoItemMnCollection
{
    protected $lottoItems;
    protected $transformResults = [];
    public function __construct(Collection $lottoItems)
    {
        $this->lottoItems = $lottoItems;
    }
    public function transfromLottoItems()
    {
        if (count($this->transformResults) > 0) return $this->transformResults;
        $transformResults = [];
        foreach ($this->lottoItems as $keyItem => $lottoItem) {
            $lottoRecord = $lottoItem->lottoRecords()->orderBy('created_at', 'desc')->first();
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
        if (count($this->transformResults) == 0) $this->transfromLottoItems();
        return new HeadTailMn($this->transformResults);
    }

    /**
     * Get the value of transformResults
     *
     * @return  mixed
     */
    public function getTransformResults()
    {
        if (count($this->transformResults) == 0) $this->transfromLottoItems();
        return $this->transformResults;
    }
}
