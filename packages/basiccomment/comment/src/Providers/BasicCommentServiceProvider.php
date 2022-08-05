<?php
namespace basiccomment\comment\Providers;
use Illuminate\Support\ServiceProvider;
class BasicCommentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../Views','basiccmt');
        $this->loadRoutesFrom(__DIR__.'/../Routes/route.php');
    }
}
