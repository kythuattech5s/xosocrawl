<?php

namespace Lotto\Dtos;

use Arr;

class HeadTailMn extends HeadTail
{
    protected function calculate()
    {
        foreach ($this->details as $key =>  $itemPrizes) {
            foreach ($itemPrizes as $itemPrize) {

                if (!array_key_exists('item', $itemPrize)) continue;

                $item = $itemPrize['item'];
                $itemId = $item->id;
                $this->initArrayHead($itemId, $item);

                if (!array_key_exists('numbers', $itemPrize)) {
                    continue;
                }

                $numbers = $itemPrize['numbers'];

                foreach ($numbers as $lottoResultDetail) {
                    $number = $lottoResultDetail->number;
                    $no_prize = $lottoResultDetail->no_prize;
                    $twoLastNumber = substr($number, -2);
                    $firstHead = substr($twoLastNumber, 0, 1);
                    $firstTail = substr($twoLastNumber, -1);
                    if (!Arr::exists($this->head, $firstHead)) {
                        $this->head[$firstHead] = [];
                    }
                    if (!Arr::exists($this->tail, $firstTail)) {
                        $this->tail[$firstTail] = [];
                    }
                    $this->head[$firstHead][$itemId]['numbers'][] = new HeadTailObject($no_prize, $firstTail);
                }
            }
        }
        $this->isCalculate = true;
    }
    private function initArrayHead($itemId, $item)
    {
        for ($i = -1; $i < 10; $i++) {
            $key = $i . '';
            if (!array_key_exists($key, $this->head)) {
                $this->head[$key] = [];
            }
            if (!array_key_exists($itemId, $this->head[$key])) {
                $this->head[$key][$itemId]['item'] = $item;
                $this->head[$key][$itemId]['numbers'] = [];
            }
        }
    }
}
