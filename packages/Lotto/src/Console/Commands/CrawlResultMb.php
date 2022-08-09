<?php

namespace Lotto\Console\Commands;

use Illuminate\Console\Command;
use Lotto\Enums\CrawlStatus;
use Lotto\Models\LottoCategory;
use Lotto\Models\LottoItem;
use Lotto\Models\LottoRecord;
use Lotto\Processors\XoSoMienBac;

class CrawlResultMb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lotto:crawl-mb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl Xo So All';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    protected $year = 2001;
    public function handle()
    {
        $lottoItems = LottoCategory::find(1)->lottoItems;
        $this->info('Start');
        foreach ($lottoItems as $lottoItem) {
            $this->crawlSingle($lottoItem);
        }
        $this->info('End');
    }
    protected function crawlSingle($lottoItem)
    {
        $dates = $this->getDates($lottoItem);
        $dates = array_reverse($dates);
        $xsmb = new XoSoMienBac($lottoItem);
        $this->info('Start ' . $lottoItem->name);
        foreach ($dates as $date) {
            $this->info($date);
            $record = LottoRecord::getRecordByDate($lottoItem, $date);
            if ($record && $record->status == CrawlStatus::SUCCESS) {
                continue;
            }

            $xsmb->setDateCrawl($date);
            $result = $xsmb->parseTableResult();

            $record->description = $result->getDescription();
            $record->status = $result->getStatus();
            $record->crawl_response = $result->getNote();
            $record->save();

            $record->insertResults($result->getDatas(), $date);
        }
        $this->info('End ' . $lottoItem->name);
    }
    protected function getDates($lottoItem)
    {
        $lottoTimes = $lottoItem->lottoTimes;
        $now = now();
        $firstTime = $lottoTimes[0];
        $ddofweek = $firstTime->dayofweek;
        $ddofweek = $ddofweek == 8 ? 0 : $ddofweek - 1;
        for ($i = 0; $i < 7; $i++) {
            $now->addDays(-1);
            if ($now->dayOfWeek == $ddofweek) {
                break;
            }
        }

        $times = [];
        foreach ($lottoTimes as $time) {
            $times[] = $time->dayofweek;
        }


        $count = 0;
        $date = clone $now;

        $dates = [];
        do {
            $dates[] = clone $date;
            $minus = $this->getMinusByCount($count, $times);
            $date = $date->addDays($minus);
            $count++;
        } while ($date->year > $this->year);
        return $dates;
    }
    protected function getMinusByCount($count, $times)
    {
        $minus = 0;
        for ($i = 0; $i < count($times); $i++) {
            $time = $times[$i];
            if ($count % count($times) == $i) {
                $iprev = $i == 0 ? count($times) - 1 : $i - 1;
                $vprev = $times[$iprev];
                $minus = $time > $vprev ? $time - $vprev : $time + 7 - $vprev;
                $minus = -abs($minus);
            }
        }
        return $minus;
    }
}
