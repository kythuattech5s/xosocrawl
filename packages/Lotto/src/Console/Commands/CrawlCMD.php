<?php

namespace Lotto\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Lotto\Enums\CrawlStatus;
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
        $lottoItem = LottoItem::find(1);
        $date = now()->addDays(-1);
        $record = LottoRecord::getRecordByDate($lottoItem, $date);
        if ($record && $record->status == CrawlStatus::SUCCESS) {
            return;
        }
        $xsmb = new XoSoMienBac($lottoItem);
        $xsmb->setDateCrawl($date);
        $result = $xsmb->parseTableResult();

        $record->description = $result->getDescription();
        $record->status = $result->getStatus();
        $record->crawl_response = $result->getNote();
        $record->save();

        $record->insertResults($result->getDatas(), $date);
        // $items = LottoItem::get();
        // foreach ($items as $key => $item) {
        //     $shortName = 'XS';
        //     $name = $item->name;
        //     $names = explode(' ', $name);
        //     foreach ($names as $n) {
        //         $shortName .= strtoupper(Str::slug(substr($n, 0, 1)));
        //     }
        //     $item->short_name = $shortName;
        //     $item->save();
        // }
        // $records = LottoRecord::get();
        // foreach ($records as $key => $record) {
        //     $this->info($record->fullcode);
        //     $code = $record->fullcode;
        //     $date = \Carbon\Carbon::createFromFormat('Ymd', $code);
        //     $record->created_at = $record->created_at->setDate($date->year, $date->month, $date->day);
        //     $record->updated_at = $record->created_at;
        //     $record->save();
        // }

        // $details = LottoResultDetail::where('lotto_item_id',1)->get();
        // foreach ($details as $key => $detail) {
        //     $this->info($detail->id);
        //     $record = LottoRecord::find('id',$detail->lotto_record_id);
        //     if($record){
        //         $detail->created_at = $record->created_at;
        //         $detail->updated_at = $record->created_at;
        //         $detail->save();
        //     }

        // }
    }
}
