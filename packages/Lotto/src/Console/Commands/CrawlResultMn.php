<?php

namespace Lotto\Console\Commands;

use Illuminate\Console\Command;
use Lotto\Models\LottoItem;
use Lotto\Models\LottoRecord;
use Lotto\Processors\XoSoMienBac;
use Lotto\Processors\XoSoMienNam;

class CrawlResultMn extends CrawlResultMb
{
    protected $signature = 'lotto:crawl-mn';
    protected $year = 2009;
    public function handle()
    {
        $lottoItems = LottoItem::where('lotto_category_id', 3)->where('id', '>', 18)->get();
        $this->info('Start');
        foreach ($lottoItems as $lottoItem) {
            $this->info('Start ' . $lottoItem->name);
            $this->crawlOne($lottoItem);
            $this->info('End ' . $lottoItem->name);
        }
        $this->info('End');
    }
    public function crawlOne($lottoItem)
    {
        $dates = $this->getDates($lottoItem);
        $dates = array_reverse($dates);
        $xsmb = new XoSoMienNam($lottoItem);

        foreach ($dates as $date) {
            $this->info($date);
            $xsmb->setDateCrawl($date);
            $result = $xsmb->parseTableResult();

            $record = LottoRecord::getRecordByDate($lottoItem, $date);
            $record->description = $result->getDescription();
            $record->status = $result->getStatus();
            $record->crawl_response = $result->getNote();
            $record->save();

            $record->insertResults($result->getDatas(), $date);
        }
    }
}
