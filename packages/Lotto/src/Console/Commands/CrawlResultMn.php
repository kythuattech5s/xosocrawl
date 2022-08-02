<?php

namespace Lotto\Console\Commands;

use Illuminate\Console\Command;
use Lotto\Models\LottoItem;
use Lotto\Models\LottoRecord;
use Lotto\Processors\XoSoMienBac;
use Lotto\Processors\XoSoMienNam;

class CrawlResultMn extends CrawlResultMb
{
    protected $signature = 'lotto:crawl-mn {id}';
    protected $year = 2009;
    public function handle()
    {
        $lottoItem = LottoItem::find($this->argument('id'));
        $dates = $this->getDates($lottoItem);
        $dates = array_reverse($dates);
        $xsmb = new XoSoMienNam($lottoItem);
        $this->info('Start');
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
        $this->info('End');
    }
}
