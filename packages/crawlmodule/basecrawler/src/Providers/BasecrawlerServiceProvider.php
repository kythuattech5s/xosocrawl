<?php
namespace crawlmodule\basecrawler\Providers;
use Illuminate\Support\ServiceProvider;
class BasecrawlerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return voids
     */
    public function register()
    {
        $this->commands([
            \crawlmodule\basecrawler\Commands\Crawler::class
        ]);
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}