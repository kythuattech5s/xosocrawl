<?php

namespace Lotto\Dtos;

use Arr;

class HeadTailMn extends HeadTail
{
    protected function calculate()
    {
        foreach ($this->details as  $items) {
            foreach ($items as $item) {
                if (!array_key_exists('numbers', $item)) continue;
                $details = $item['numbers'];
                foreach ($details as $detail) {
                    $number = $detail->number;
                    $no_prize = $detail->no_prize;
                    $twoLastNumber = substr($number, -2);
                    $firstHead = substr($twoLastNumber, 0, 1);
                    $firstTail = substr($twoLastNumber, -1);
                    if (!Arr::exists($this->head, $firstHead)) {
                        $this->head[$firstHead] = [];
                    }
                    if (!Arr::exists($this->tail, $firstTail)) {
                        $this->tail[$firstTail] = [];
                    }
                    $this->head[$firstHead][] = new HeadTailObject($no_prize, $firstTail);
                    $this->tail[$firstTail][] = new HeadTailObject($no_prize, $firstHead);
                }
            }
        }
        $this->isCalculate = true;
    }
}
