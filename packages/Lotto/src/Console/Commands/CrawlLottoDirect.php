<?php
namespace Lotto\Console\Commands;

use crawlmodule\basecrawler\Crawlers\BaseCrawler;
use Illuminate\Console\Command;
use Lotto\Models\LottoCategory;
use Lotto\Models\LottoItem;
use Support;

class CrawlLottoDirect extends Command
{
    const EMPTY_DATA = 100;
    const DATA_CRAWL_FULL = 200;
    const WRONG_DATE = 300;
    const IN_CONTINUE = 400;
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
        $this->info(now()->format('d/m/Y H:i:s').': Khởi động hệ thống crawl kết quả quay số trực tiếp.');
        $fullBac = false;
        $fullTrung = false;
        $fullNam = false;

        $wrongDateCountBac = 0;
        $wrongDateCountTrung = 0;
        $wrongDateCountNam = 0;
        
        while (true) {
            $hour = now()->hour;
            $minute = now()->minute;

            if (!($hour == 16 && $minute >= 15 && $minute <= 45)) {
                $fullNam = false;
                $wrongDateCountNam = 0;
            }
            if (!($hour == 17 && $minute >= 15 && $minute <= 45)) {
                $fullTrung = false;
                $wrongDateCountTrung = 0;
            }
            if (!($hour == 18 && $minute >= 15 && $minute <= 45)) {
                $fullBac = false;
                $wrongDateCountBac = 0;
            }

            if ($hour == 16 && $minute >= 15 && $minute <= 45 && !$fullNam && $wrongDateCountNam < 10) {
                $statusNam = $this->crawlDirectLottoMienNam();
                if ($statusNam == self::WRONG_DATE) {
                    $wrongDateCountNam++;
                    $this->info(now()->format('d/m/Y H:i:s').': Sai ngày Nam');
                }
                if ($statusNam == self::DATA_CRAWL_FULL) {
                    $fullNam = true;
                    $this->info(now()->format('d/m/Y H:i:s').': Đã đụ dữ liệu Nam');
                }
                sleep(4);
            }elseif ($hour == 17 && $minute >= 15 && $minute <= 45 && !$fullTrung && $wrongDateCountTrung < 10) {
                $statusTrung = $this->crawlDirectLottoMienTrung();
                if ($statusTrung == self::WRONG_DATE) {
                    $wrongDateCountTrung++;
                    $this->info(now()->format('d/m/Y H:i:s').': Sai ngày Trung');
                }
                if ($statusTrung == self::DATA_CRAWL_FULL) {
                    $fullTrung = true;
                    $this->info(now()->format('d/m/Y H:i:s').': Đã đủ dữ liệu Trung');
                }
                sleep(4);
            }elseif ($hour == 18 && $minute >= 15 && $minute <= 45 && !$fullBac && $wrongDateCountBac < 10) {
                $statusBac = $this->crawlDirectLottoMienBac();
                if ($statusBac == self::WRONG_DATE) {
                    $wrongDateCountBac++;
                    $this->info(now()->format('d/m/Y H:i:s').': Sai ngày Bắc');
                }
                if ($statusBac == self::DATA_CRAWL_FULL) {
                    $fullBac = true;
                    $this->info(now()->format('d/m/Y H:i:s').': Đã đủ dữ liệu Bắc');
                }
                sleep(4);
            }else{
                $this->info(now()->format('d/m/Y H:i:s').': Tạm thời đang không thuộc về ai.');
                sleep(60);
            }
        }
        $this->info(now()->format('d/m/Y H:i:s').': Đóng hệ thống crawl kết quả quay số trực tiếp.');
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
    public function checkTime($timeMilisecond)
    {
        $timestamp = (int)($timeMilisecond/1000);
        $time = now()->createFromTimestamp($timestamp);
        return $time->startOfDay()->diff(now()->startOfDay())->days == 0;
    }
    public function crawlDirectLottoMienNam()
    {
        $this->info(now()->format('d/m/Y H:i:s').': Đang câu miền Nam');
        $lottoCategory = LottoCategory::find(3);
        $arrData = $this->getDirectData($lottoCategory);

        if (!(count($arrData) > 0)) return self::EMPTY_DATA;

        $isFull = true;
        foreach ($arrData as $itemData) {
            $lottoItem = LottoItem::where('name',$itemData['provinceName'] ?? '')->first();
            if (isset($lottoItem)) {
                $time = now();
                if (!$this->checkTime($itemData['resultDate'] ?? 0)) return self::WRONG_DATE;
                $statusFull = $lottoItem->createDataDirect($itemData['lotData'],$time);
                if (!$statusFull) {
                    $isFull = false;
                }
            }
        }
        if ($isFull) {
            return self::DATA_CRAWL_FULL;
        }
        return self::IN_CONTINUE;
    }
    public function crawlDirectLottoMienTrung()
    {
        $this->info(now()->format('d/m/Y H:i:s').': Đang câu miền Trung');
        $lottoCategory = LottoCategory::find(4);
        $arrData = $this->getDirectData($lottoCategory);

        if (!(count($arrData) > 0)) return self::EMPTY_DATA;

        $isFull = true;
        foreach ($arrData as $itemData) {
            $lottoItem = LottoItem::where('name',$itemData['provinceName'] ?? '')->where('lotto_category_id',$lottoCategory->id)->first();
            if (isset($lottoItem)) {
                $time = now();
                if (!$this->checkTime($itemData['resultDate'] ?? 0)) return self::WRONG_DATE;
                $statusFull = $lottoItem->createDataDirect($itemData['lotData'],$time);
                if (!$statusFull) {
                    $isFull = false;
                }
            }
        }
        if ($isFull) {
            return self::DATA_CRAWL_FULL;
        }
        return self::IN_CONTINUE;
    }
    public function crawlDirectLottoMienBac()
    {
        $this->info(now()->format('d/m/Y H:i:s').': Đang câu miền Bắc');
        $lottoCategory = LottoCategory::find(1);
        $arrData = $this->getDirectData($lottoCategory);
        
        if (!(count($arrData) > 0)) return self::EMPTY_DATA;

        $time = now();
        if (!$this->checkTime($arrData['resultDate'] ?? 0)) return self::WRONG_DATE;
        
        $timeShow = $time->dayOfWeek == 0 ? 8:$time->dayOfWeek+1;
        $lottoItems= LottoItem::where('lotto_category_id',$lottoCategory->id)->whereRaw('FIND_IN_SET(?,time_show)', [$timeShow])->get();
        $isFull = true;
        foreach ($lottoItems as $lottoItem) {
            $statusFull = $lottoItem->createDataDirect($arrData['lotData'],$time);
            if (!$statusFull) {
                $isFull = false;
            }
        }
        if ($isFull) {
            return self::DATA_CRAWL_FULL;
        }
        return self::IN_CONTINUE;
    }
}