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
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/routes.php');
    }
}