<?php
namespace crawlmodule\basecrawler\Commands;
use Illuminate\Console\Command;
use App\Models\CrawlType;
use crawlmodule\basecrawler\Crawlers\Factory\CrawlerFactory;

class Crawler extends Command
{
    protected $signature = 'crawler:start-crawl {type}';
    protected $type;
    protected $description = 'Start crawl active type';

    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $type = $this->argument('type');
        $crawlType = CrawlType::where('type',$type)->first();
        if (isset($crawlType)) {
            $crawler = CrawlerFactory::getCrawler($crawlType->type);
            $this->info('Bắt đầu Crawl '.$crawlType->name);
            $status = $crawler->startCrawl();
            if ($status) {
                $this->info('Crawl '.$crawlType->name.' thành công.');
            }else{
                $this->info('Kết thúc Crawl '.$crawlType->name.' với một lỗi gì đó.');
            }
        }else{
            $this->info('Không có phương thức nào');
        }
    }
}