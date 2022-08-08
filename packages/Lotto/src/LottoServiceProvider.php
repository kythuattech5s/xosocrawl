<?php

namespace Lotto;

use Arr;
use Illuminate\Console\Application as Artisan;
use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use Str;
use Symfony\Component\Finder\Finder;

class LottoServiceProvider extends ServiceProvider
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
        if ($this->app->runningInConsole()) {
            $this->loadCommands();
        }
        $this->loadRoutes();
    }
    protected function loadCommands()
    {
        $this->load(__DIR__ . '/Console/Commands');
    }
    protected function load($paths)
    {
        $paths = array_unique(Arr::wrap($paths));

        $paths = array_filter($paths, function ($path) {
            return is_dir($path);
        });

        if (empty($paths)) {
            return;
        }

        $namespace = 'Lotto\\';

        foreach ((new Finder)->in($paths)->files() as $command) {
            $command = $namespace . str_replace(
                ['/', '.php'],
                ['\\', ''],
                Str::after($command->getRealPath(), __DIR__ . DIRECTORY_SEPARATOR)
            );
            if (
                is_subclass_of($command, Command::class) &&
                !(new ReflectionClass($command))->isAbstract()
            ) {
                Artisan::starting(function ($artisan) use ($command) {
                    $artisan->resolve($command);
                });
            }
        }
    }
    public function loadRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }
}
