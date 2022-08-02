<?php

namespace Lotto\Console\Commands;

use Illuminate\Console\Command;
use Lotto\Models\LottoItem;
use Lotto\Processors\XoSoMienBac;

class CrawlResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lotto:crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl Xo So';

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
    public function handle()
    {
        $lottoItem = LottoItem::find(1);

        $xsmb = new XoSoMienBac($lottoItem);
        $date = now()->addDays(-1);
        $xsmb->setDateCrawl($date);

        $result = $xsmb->parseTableResult();
        dd($result);
    }
}
