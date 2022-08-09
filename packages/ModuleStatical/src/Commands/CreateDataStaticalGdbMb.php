<?php
namespace ModuleStatical\Commands;
use Illuminate\Console\Command;
use ModuleStatical\Gdbmb\ModuleStaticalGdbmb;

class CreateDataStaticalGdbMb extends Command
{
    protected $signature = 'statical:create-data-statical-gdb-mb {type}';
    protected $type;
    protected $description = 'Create data statical';

    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $type = $this->argument('type');
        ModuleStaticalGdbmb::createStaticalData($type);
    }
}