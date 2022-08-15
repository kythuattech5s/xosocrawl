<?php

namespace Lotto\Dtos;

use Arr;

class HeadTail
{
    protected $head = [0 => [], 1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => []];
    protected $tail = [0 => [], 1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [], 7 => [], 8 => [], 9 => []];

    protected $details;
    protected $isCalculate = false;
    public function __construct($details)
    {
        $this->details = $details;
    }
    public function getHeads()
    {
        if (!$this->isCalculate) {
            $this->calculate();
        }
        return $this->head;
    }
    public function getTails()
    {
        if (!$this->isCalculate) {
            $this->calculate();
        }
        return $this->tail;
    }
    protected function calculate()
    {
        foreach ($this->details as  $detail) {
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
        $this->isCalculate = true;
    }
}
class HeadTailObject
{
    protected $noPrize;
    protected $number;
    public function __construct($noPrize, $number)
    {
        $this->noPrize = $noPrize;
        $this->number = $number;
    }
    public function isSpecial()
    {
        return $this->noPrize == 0;
    }
    public function getNumber()
    {
        return $this->number;
    }
}
