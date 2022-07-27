<?php
namespace CustomTable\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class CustomTableProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->initConfigFile();
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(base_path(). '/packages/table_customs/src/Routes/route.php');
    }


    private function initConfigFile(){
        $arr = glob(base_path() . "/packages/table_customs/src/Config/*.php");
        foreach ($arr as $key => $value) {
           $nameConfig = pathinfo($value)['filename'];
            if($nameConfig !== 'app'){
                \Config::set('sys_'.$nameConfig,include_once $value);
            }
        }
    }
}
