<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use vanhenry\manager\model\Media;

class HomeController extends Controller
{
    public function index(Request $request){
        return view('home');
    }

    public function direction(Request $request, $link)
    {
        $lang = \App::getLocale();
        $link = \FCHelper::getSegment($request, 1);
        $route = \DB::table('v_routes')->select('*')->where($lang.'_link', $link)->first();
        if ($route == null) {
            abort(404);
        }
        $controllers = explode('@', $route->controller);
        $controller = $controllers[0];
        $method = $controllers[1];
        return (new $controller)->$method($request, $route, $link);
    }
}
