<?php
namespace crawlmodule\basecrawler\Commands;
use Illuminate\Console\Command;
use App\Models\CrawlType;
use crawlmodule\basecrawler\Crawlers\Factory\CrawlerFactory;

class Crawler extends Command
{
    protected $signature = 'crawler:start-crawl';

    protected $description = 'Start crawl active type';

    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $listActiveCrawlType = CrawlType::act()->get();
        if (count($listActiveCrawlType) > 0) {
            foreach ($listActiveCrawlType as $itemActiveCrawlType) {
                $this->info('Bắt đầu Crawl '.$itemActiveCrawlType->name);
                $crawler = CrawlerFactory::getCrawler($itemActiveCrawlType->type);
                $status = $crawler->startCrawl();
                if ($status) {
                    $this->info('Crawl '.$itemActiveCrawlType->name.' thành công.');
                }else{
                    $this->info('Kết thúc Crawl '.$itemActiveCrawlType->name.' với một lỗi gì đó.');
                }
            }
        }else{
            $this->info('Không có phương thức nào');
        }
    }
}