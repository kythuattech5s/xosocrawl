<?php
namespace basiccomment\comment\Controllers;
use Illuminate\Routing\Controller as BaseController;
class Controller extends BaseController
{
    public function file($source,$filename)
    {
        $path = '/packages/basiccomment/comment/src/Theme/'.$source.'/'.$filename;
        $fullPath =  base_path().$path;
        if (!file_exists($fullPath)) {
            abort(404);
        }
        $mime = \File::mimeType($fullPath);
        $pathinfo = pathinfo($fullPath);
        if($mime == 'text/plain' && $pathinfo['extension'] == 'css'){
            $mime = 'text/css';
        }
        $headers = [
            "Content-Type" => $mime,
            "path-link" => $path,
            "cache-control" => "public, max-age=31536000, s-maxage=31536000, immutable"
        ];
        ob_end_clean();
        return response()->file($fullPath, $headers);
    }
}