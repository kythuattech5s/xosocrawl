<?php
namespace Lotto\Console\Commands;

use crawlmodule\basecrawler\Crawlers\BaseCrawler;
use Illuminate\Console\Command;
use Lotto\Models\LottoCategory;
use Lotto\Models\LottoItem;
use Support;

class CrawlLottoDirect extends Command
{
    protected $signature = 'lotto:direct-crawl';
    protected $type;
    protected $description = 'Start crawl lotto truc tiep';
    protected $baseCrawler;
    protected $arrCrawlChannel = [1,2,3,4,5,8];

    public function __construct()
    {
        $this->baseCrawler = new BaseCrawler;
        parent::__construct();
    }
    public function handle()
    {
        $this->info('Khởi động hệ thống crawl kết quả quay số trực tiếp.');
        $hLock=fopen(base_path("crawlDirectLotto.lock"), "w+");
        if(!flock($hLock, LOCK_EX | LOCK_NB)){
            $this->info('Already running. Exiting...');
            die;
        }
        while (true) {
            $hour = now()->hour;
            $minute = now()->minute;
            if ($hour == 16 && $minute >= 15 && $minute <= 45) {
                $this->crawlDirectLottoMienNam();
                sleep(4);
            }elseif ($hour == 17 && $minute >= 15 && $minute <= 45) {
                $this->crawlDirectLottoMienTrung();
                sleep(4);
            }elseif ($hour == 18 && $minute >= 15 && $minute <= 45) {
                $this->crawlDirectLottoMienBac();
                sleep(4);
            }else{
                $this->info('Tạm thời đang không thuộc về ai.');
                sleep(60);
            }
        }
        flock($hLock, LOCK_UN);
        fclose($hLock);
        unlink(base_path("crawlDirectLotto.lock"));
        $this->info('Đóng hệ thống crawl kết quả quay số trực tiếp.');
    }
    public function getDirectData($lottoCategory)
    {
        if (!isset($lottoCategory)) {
            return [];
        }
        $crawlLink = vsprintf($lottoCategory->link_crawl_direct,[$this->arrCrawlChannel[array_rand($this->arrCrawlChannel)]]);
        $ret = $this->baseCrawler->exeCurl($crawlLink);
        $arrData = Support::extractJson($ret);
        return $arrData;
    }
    public function crawlDirectLottoMienNam()
    {
        $this->info('Đang câu miền Nam');
        $lottoCategory = LottoCategory::find(3);
        $arrData = $this->getDirectData($lottoCategory);
        if (!(count($arrData) > 0)) return;
        foreach ($arrData as $itemData) {
            $lottoItem = LottoItem::where('name',$itemData['provinceName'] ?? '')->first();
            if (isset($lottoItem)) {
                $time = now();
                $lottoItem->createDataDirect($itemData['lotData'],$time);
            }
        }
    }
    public function crawlDirectLottoMienTrung()
    {
        $this->info('Đang câu miền Trung');
        $lottoCategory = LottoCategory::find(4);
        $arrData = $this->getDirectData($lottoCategory);
        if (!(count($arrData) > 0)) return;
        foreach ($arrData as $itemData) {
            $lottoItem = LottoItem::where('name',$itemData['provinceName'] ?? '')->where('lotto_category_id',$lottoCategory->id)->first();
            if (isset($lottoItem)) {
                $time = now();
                $lottoItem->createDataDirect($itemData['lotData'],$time);
            }
        }
    }
    public function crawlDirectLottoMienBac()
    {
        $this->info('Đang câu miền Bắc');
        $lottoCategory = LottoCategory::find(1);
        $arrData = $this->getDirectData($lottoCategory);
        if (!(count($arrData) > 0)) return;
        $time = now();
        $timeShow = $time->dayOfWeek == 0 ? 8:$time->dayOfWeek+1;
        $lottoItems= LottoItem::where('lotto_category_id',$lottoCategory->id)->whereRaw('FIND_IN_SET(?,time_show)', [$timeShow])->get();
        foreach ($lottoItems as $lottoItem) {
            $lottoItem->createDataDirect($arrData['lotData'],$time);
        }
    }
}