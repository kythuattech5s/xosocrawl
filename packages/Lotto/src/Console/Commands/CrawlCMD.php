<?php

namespace Lotto\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Lotto\Enums\CrawlStatus;
use Lotto\Helpers\LottoHelper;
use Lotto\Models\LottoCategory;
use Lotto\Models\LottoItem;
use Lotto\Models\LottoRecord;
use Lotto\Models\LottoResultDetail;
use Lotto\Processors\XoSoMienBac;

class CrawlCMD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lotto:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl Run';

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
        $lottoItems = LottoCategory::find(3)->lottoItems;
        foreach ($lottoItems as $key => $lottoItem) {
            $url = 'https://xoso.me/mien-nam/' . $lottoItem->slug . '.html';
            @include_once(__DIR__ . '/../../Libs/simple_html_dom.php');
            $content = LottoHelper::requestUrl($url);
            $htmlDom = \str_get_html($content);
            $box = $htmlDom->find('.box-html', 0);
            $lottoItem->content = $box->innertext;
            $lottoItem->save();
        }
    }
}
