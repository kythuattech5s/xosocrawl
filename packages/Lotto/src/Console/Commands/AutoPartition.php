<?php

namespace Lotto\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Lotto\Enums\CrawlStatus;
use Lotto\Models\LottoItem;
use Lotto\Models\LottoRecord;
use Lotto\Models\LottoResultDetail;
use Lotto\Processors\XoSoMienBac;

class AutoPartition extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lotto:partition';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Partition';

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
        $x = \DB::select('select * from lotto_categories');
        dd($x);
    }
}
