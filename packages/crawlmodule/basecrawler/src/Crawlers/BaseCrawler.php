<?php
namespace crawlmodule\basecrawler\Crawlers;
use crawlmodule\basecrawler\Crawlers\Contracts\CrawlerInterface;
use App\Helpers\Media;
use vanhenry\manager\model\VRoute as ModelVRoute;

class BaseCrawler implements CrawlerInterface
{
    protected $imageSaveDir = 'old';
    protected $clearLinkCharacters = [
        'https://xoso.me',
        '.html'
    ];
    protected $clearContentCharacters = [
        'https://xoso.me',
        '.html'
    ];
    public function __construct()
    {
        @include_once ('simple_html_dom.php');
    }
    public function exeCurl($url, $type = 'GET', $data = null, $headers = [])
    {
        $curl = curl_init();
        $params = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $type,
            CURLOPT_FOLLOWLOCATION => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        );
        if ($type == 'POST' && is_string($data)) {
            $params[CURLOPT_POSTFIELDS] = $data;
        }
        if ($type == 'POST' && is_array($data)) {
            $params[CURLOPT_POSTFIELDS] = http_build_query($data);
        }
        if ($type == 'GET' && is_array($data)) {
            $params[CURLOPT_URL] = $url . '?' . http_build_query($data);
        }
        if ($headers) {
            $params[CURLOPT_HTTPHEADER] = $headers;
        }
        curl_setopt_array($curl, $params);
        $res = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);
        if (!empty($err)) {
            return $err;
        }
        return $res;
    }
    public static function processSlug($string)
    {
        if ($string == '') {
            return '';
        }
        $slug = \Str::slug($string);
        $total = 0;
        $count = count(\DB::table('v_routes')->where('vi_link', $slug)->get());
        $total +=$count;
        $ext = $slug;
        while ($count>0) {
            $ext  = $slug.($count>0?"-".($total+1):"");
            $count = count(\DB::table('v_routes')->where('vi_link', $ext)->get());
            $total +=1;
        }
        return $ext;
    }
    public function clearLink($link)
    {
        foreach ($this->clearLinkCharacters as $itemClearCharacter) {
            $link = str_replace($itemClearCharacter,'',$link);
        }
        $link = trim($link);
        $link = trim($link,'/');
        return $link;
    }
    public function renameIfExist($path, $filename)
    {
        $img_name = \Str::slug(strtolower(pathinfo($filename, PATHINFO_FILENAME)));
        $img_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $filename = $img_name . '.' . $img_ext;
        $filecounter = 1;
        $filename = $img_name . '.' . $img_ext;
        $destinationPath = $path . $filename;
        while (file_exists($destinationPath)) {
            $filename = $img_name . '_' . ++$filecounter . '.' . $img_ext;
            $destinationPath = $path . $filename;
        }
        return strtolower($filename);
    }
    public function saveImg($linkImg, $saveFrom ,$returnPath = false)
    {
        $uploadRootDir = 'public/uploads';
        $uploadDir = $saveFrom;
        $pathRelative = $uploadRootDir . '/' . $uploadDir . '/';
        $pathAbsolute = base_path($pathRelative);
        $dirs = explode('/', $uploadDir);
        $parentId = 0;
        foreach ($dirs as $item) {
            $parentId = Media::createDir($uploadRootDir, $item, $pathRelative, $pathAbsolute, $parentId);
        }
        if (is_bool($parentId)) {
            return '';
        }
        $imgInfo = pathinfo($linkImg);
        $fileName = $imgInfo['basename'] ?? 'old-image';
        $fileName = $this->renameIfExist($pathAbsolute,$fileName);
        file_put_contents($pathAbsolute.$fileName, file_get_contents($linkImg));
        $itemMediaId = Media::insertImageMedia($uploadRootDir, $pathAbsolute, $pathRelative, $fileName, $parentId);

        \DB::table('custom_media_images')->insert([
            'name' => $pathRelative . $fileName,
            'media_id' => $itemMediaId,
            'act' => 0,
        ]);
        if ($returnPath) {
            return str_replace('public/','',$pathRelative . $fileName);
        }
        return Media::img($itemMediaId);
    }
    public function inserVRouter($item,$controller){
        $vRouter = new ModelVRoute();
        $vRouter->vi_name = $item->name ?? '';
        $vRouter->controller = $controller;
        $vRouter->table = $item->getTable();
        $vRouter->map_id = $item->id;
        $vRouter->is_static = 0;
        $vRouter->in_sitemap = 1;
        $vRouter->vi_link = $item->slug ?? '';
        $vRouter->vi_seo_title = $item->seo_title ?? $vRouter->vi_name;
        $vRouter->vi_seo_key = $item->seo_key ?? $vRouter->vi_name;
        $vRouter->vi_seo_des = $item->seo_des ?? $vRouter->vi_name;
        $vRouter->save();
    }
    public function convertContent($contentDom)
    {
        // remove widget-toc
        $widgetTocs = $contentDom->find('.widget-toc');
        foreach ($widgetTocs as $itemWidgetTocs) {
            $itemWidgetTocs->outertext = '';
        }
        // clear Link
        $listATag = $contentDom->find('a');
        foreach ($listATag as $itemA) {
            $itemA->href = $this->clearLink($itemA->href);
	    }

        // Save img In content
        $listImgs = $contentDom->find('img');
        foreach ($listImgs as $itemImg) {
            $itemImg->removeAttribute('data-src');
            $itemImg->src = $this->saveImg($itemImg->src,$this->imageSaveDir,true);
        }
        return trim($contentDom->innertext);
    }
    public function startCrawl()
    {
        return true;
    }
}
