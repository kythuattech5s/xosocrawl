<?php

namespace Lotto\Console\Commands;

use Illuminate\Console\Command;

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
        var_dump(__FILE__);
        die;
    }
}
