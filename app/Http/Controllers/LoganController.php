<?php
namespace App\Http\Controllers;

use App\Models\Logan;
use App\Models\LoganCategory;
use ModuleStatical\Helpers\ModuleStaticalHelper;
use ModuleStatical\Logan\ModuleStaticalLogan;

class LoganController extends Controller
{	
    public function view($request, $route, $link){
        $link = 'thong-ke-giai-dac-biet-theo-thang';
        \DB::select("select * from statical_crawl_configs where current_link = '$link'");
        dd($link);
    }
}