<?php

namespace Lotto\Processors;

use Lotto\Contracts\IXoSo;
use Lotto\Models\LottoItem;

abstract class AbstractXoSo implements IXoSo
{
    protected LottoItem $lottoItem;
    protected $currentDayOfWeek;
    public function __construct(LottoItem $lottoItem)
    {
        $this->lottoItem = $lottoItem;
    }
    protected function getCurrentDateOfWeek()
    {
        if (!$this->currentDayOfWeek) {
            $now = now();
            $this->currentDayOfWeek =  $now->dayOfWeek;
        }
        return $this->currentDayOfWeek;
    }
    public function getLinkByDate(): string
    {
        $link = $this->lottoItem->link_with_date;
        $count = substr_count($link, "%s");
        $params = array_fill(0, $count, '');
        $link = vsprintf($link, $params);
        return $link;
    }
}
