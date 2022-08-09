<?php
namespace ModuleStatical;
use Illuminate\Support\ServiceProvider;
class ModuleStaticalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return voids
     */
    public function register()
    {
        $this->commands([
            \ModuleStatical\Commands\CreateDataStaticalGdbMb::class
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