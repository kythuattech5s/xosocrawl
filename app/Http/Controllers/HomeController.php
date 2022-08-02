<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lotto\LottoServiceProvider;
use Lotto\Models\LottoCategory;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $isHome = 1;
        // dump(LottoCategory::find(1)->lottoTodayItems());
        return view('home', compact('isHome'));
    }

    public function direction(Request $request, $link)
    {
        $lang = \App::getLocale();
        $link = \FCHelper::getSegment($request, 1);
        $route = \DB::table('v_routes')->select('*')->where($lang . '_link', $link)->first();
        if ($route == null) {
            abort(404);
        }
        $controllers = explode('@', $route->controller);
        $controller = $controllers[0];
        $method = $controllers[1];
        return (new $controller)->$method($request, $route, $link);
    }
}
