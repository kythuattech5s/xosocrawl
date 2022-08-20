<?php

namespace Lotto\Helpers;

use Lotto\Enums\DayOfWeek;
use Lotto\Models\LottoItem;

class RollingHelper
{
    public static function getMBPrizes()
    {
        return [
            new MienXPrize(0, 'ĐB', 5),
            new MienXPrize(1, '1', 5),
            new MienXPrize(2, '2', 5, 2),
            new MienXPrize(3, '3', 5, 6),
            new MienXPrize(4, '4', 4, 4),
            new MienXPrize(5, '5', 4, 6),
            new MienXPrize(6, '6', 3, 3),
            new MienXPrize(7, '7', 2, 4),

        ];
    }
    public static function getMXPrizes($categoryId)
    {
        $dayOfWeek = DayOfWeek::fromDate(now()); //->addDays(-1));
        $day = $dayOfWeek->getValue();
        $lottoItems = LottoItem::select('*')->whereHas('lottoTimes', function ($q) use ($categoryId, $day) {
            $q->where('lotto_category_id', $categoryId)->where('dayofweek', $day);
        })->get();
        $result = new \stdClass;
        $result->lottoItems = $lottoItems;
        $result->prizes = [
            new MienXPrize(8, '8', 2),
            new MienXPrize(7, '7', 3),
            new MienXPrize(6, '6', 4, 3),
            new MienXPrize(5, '5', 4),
            new MienXPrize(4, '4', 5, 7),
            new MienXPrize(3, '3', 5, 2),
            new MienXPrize(2, '2', 5),
            new MienXPrize(1, '1', 5),
            new MienXPrize(0, 'ĐB', 6),
        ];
        return $result;
    }
}
class MienXPrize
{
    protected $index;
    protected $name;
    protected $numPrize = 1;
    protected $noNumber = 3;
    public function __construct($index, $name, $noNumber, $numPrize = 1)
    {
        $this->index = $index;
        $this->name = $name;
        $this->noNumber = $noNumber;

        $this->numPrize = $numPrize;
    }
    public function getIndex()
    {
        return $this->index;
    }
    public function getName()
    {
        return $this->index != 0 ? 'Giải ' . $this->name : $this->name;
    }
    public function getShortName()
    {
        return $this->index != 0 ? 'G' . $this->name : $this->name;
    }
    public function getNumPrize()
    {
        return $this->numPrize;
    }
    public function getClassCss()
    {
        return $this->index != 0 ? $this->name : 'db';
    }
    public function getNoNumber()
    {
        return $this->noNumber;
    }
}
