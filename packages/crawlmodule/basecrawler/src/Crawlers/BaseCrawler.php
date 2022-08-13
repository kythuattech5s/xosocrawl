<?php

namespace crawlmodule\basecrawler\Crawlers;

use crawlmodule\basecrawler\Crawlers\Contracts\CrawlerInterface;
use App\Helpers\Media;
use vanhenry\manager\model\VRoute as ModelVRoute;
use vanhenry\manager\model\Media as ModelMedia;

class BaseCrawler implements CrawlerInterface
{
    protected $typeModal;
    protected $imageSaveDir = 'old';
    protected $clearLinkCharacters = [
        'https://xoso.me',
        '.html'
    ];
    protected $clearContentCharacters = [
        'https://xoso.me',
        'xoso.me',
        'Xoso.me',
        'xosome',
        'Xosome'
    ];
    protected $fileNameReplaceCharacters = [
        'xosome' => 'xosovnme',
        'Xosome' => 'Xosovnme'
    ];
    public function __construct()
    {
        @include_once('simple_html_dom.php');
    }
    public function setImageSaveDir($imageSaveDir)
    {
        $this->imageSaveDir = $imageSaveDir;
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
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        );
        if ($type == 'POST' && is_string($data)) {
            $params[CURLOPT_POSTFIELDS] = $data;
        }
        if ($type == 'POST' && is_array($data) && count($data) > 0) {
            $params[CURLOPT_POSTFIELDS] = http_build_query($data);
        }
        if ($type == 'GET' && is_array($data) && count($data) > 0) {
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
        $total += $count;
        $ext = $slug;
        while ($count > 0) {
            $ext  = $slug . ($count > 0 ? "-" . ($total + 1) : "");
            $count = count(\DB::table('v_routes')->where('vi_link', $ext)->get());
            $total += 1;
        }
        return $ext;
    }
    public function clearLink($link)
    {
        foreach ($this->clearLinkCharacters as $itemClearCharacter) {
            $link = str_replace($itemClearCharacter, '', $link);
        }
        $link = trim($link);
        $link = trim($link, '/');
        return $link;
    }
    public function clearContent($content)
    {
        foreach ($this->clearContentCharacters as $itemClearCharacter) {
            $content = str_replace($itemClearCharacter, '', $content);
        }
        $content = trim($content);
        return $content;
    }
    // public function blockTextImage($imagePath){
    //     // if (\SettingHelper::getSetting('block_text_crawl_image',0) == 1) {
    //     //     $this->blockTextImage($pathAbsolute . $fileName);
    //     // }
    //     $visionClient = new ImageAnnotatorClient([
    //         'projectId' => \SettingHelper::getSetting('gg_vision_project_id',0),
    //         'keyFilePath' => \SettingHelper::getSettingFile('gg_vision_credential_file'),
    //         'credentials' => \SettingHelper::getSettingFile('gg_vision_credential_file')
    //     ]);
    //     $textNeedBlockInImage = \SettingHelper::getSetting('block_text_crawl_image_word');
    //     $arrTextNeedBlockInImage = explode(',',$textNeedBlockInImage);
    //     foreach ($arrTextNeedBlockInImage as $key => $item) {
    //         $arrTextNeedBlockInImage[$key] = trim($item);
    //     }

    //     $response = $visionClient->textDetection(
    //         fopen($imagePath, 'r'),
    //         ['TEXT_DETECTION']
    //     );
    //     $annotation = $response->getTextAnnotations();
    //     for ($i=0; $i < $annotation->count(); $i++) { 
    //         $container = $annotation->offsetGet($i);
    //         if (in_array($container->getDescription(),$arrTextNeedBlockInImage) && $container->hasBoundingPoly()) {
    //             $boundingPoly = $container->getBoundingPoly();
    //             $vertices = $boundingPoly->getVertices();
    //             if ($vertices->count() == 4) {
    //                 $arrPositonText = [
    //                     'top-left' => [
    //                         'x' => $vertices->offsetGet(0)->getX(),
    //                         'y' => $vertices->offsetGet(0)->getY()
    //                     ],
    //                     'top-right' => [
    //                         'x' => $vertices->offsetGet(1)->getX(),
    //                         'y' => $vertices->offsetGet(1)->getY()
    //                     ],
    //                     'bottom-right' => [
    //                         'x' => $vertices->offsetGet(2)->getX(),
    //                         'y' => $vertices->offsetGet(2)->getY()
    //                     ],
    //                     'bottom-left' => [
    //                         'x' => $vertices->offsetGet(3)->getX(),
    //                         'y' => $vertices->offsetGet(3)->getY()
    //                     ]
    //                 ];
    //                 $itemPosition = [
    //                     'x' => $arrPositonText['top-left']['x'] >= 10 ? $arrPositonText['top-left']['x'] - 10:0,
    //                     'y' => $arrPositonText['top-left']['y'] >= 10 ? $arrPositonText['top-left']['y'] - 10:0,
    //                     'width'=> $arrPositonText['top-right']['x'] - $arrPositonText['top-left']['x'] + 20,
    //                     'height'=> $arrPositonText['bottom-left']['y'] - $arrPositonText['top-left']['y'] + 20
    //                 ];
    //                 $img = \Image::make($imagePath);
    //                 $watermark = \Image::make(\SettingHelper::getSettingFile('block_text_crawl_image_image'));
    //                 if ($itemPosition['width']/$itemPosition['height'] <= $watermark->width()/$watermark->height()) {
    //                     $watermark->resize(null,$itemPosition['height'], function ($constraint) {
    //                         $constraint->aspectRatio();
    //                     });
    //                 }else{
    //                     $watermark->resize($itemPosition['width'], null, function ($constraint) {
    //                         $constraint->aspectRatio();
    //                     });
    //                 }
    //                 $img->insert($watermark,'top-left',$itemPosition['x'],$itemPosition['y']);
    //                 $img->save($imagePath);
    //             }
    //         }
    //     }
    // }
    public function saveImg($linkImg, $saveFrom, $returnPath = false)
    {
        try {
            $uploadRootDir = 'uploads';
            $uploadDir = $saveFrom;
            $pathRelative = $uploadRootDir . '/' . $uploadDir . '/';
            $pathAbsolute = public_path($pathRelative);
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
            foreach ($this->fileNameReplaceCharacters as $key => $itemFileNameReplaceCharacters) {
                $fileName = str_replace($key,$itemFileNameReplaceCharacters,$fileName);
            }

            if (file_exists($pathAbsolute . $fileName)) {
                if ($returnPath) {
                    return $pathRelative . $fileName;
                }
                $itemMedia = ModelMedia::where('file_name',$fileName)->where('parent',$parentId)->first();
                if (isset($itemMedia)) {
                    return Media::img($itemMedia->id);
                }
            }
            file_put_contents($pathAbsolute . $fileName, file_get_contents($linkImg));
            $itemMediaId = Media::insertImageMedia($uploadRootDir, $pathAbsolute, $pathRelative, $fileName, $parentId);
            \DB::table('custom_media_images')->insert([
                'name' => $pathRelative . $fileName,
                'media_id' => $itemMediaId,
                'act' => 0,
            ]);
            if ($returnPath) {
                return $pathRelative . $fileName;
            }
            return Media::img($itemMediaId);
        } catch (\Throwable $th) {
            return '';
        }
    }
    public function inserVRouter($item, $controller)
    {
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

        // remove table-sms
        $tableSmses = $contentDom->find('.table-sms');
        foreach ($tableSmses as $itemtableSms) {
            $itemtableSms->outertext = '';
        }

        // remove script
        $scripts = $contentDom->find('script');
        foreach ($scripts as $itemScript) {
            $itemScript->outertext = '';
        }
        $fbShares = $contentDom->find('.fb-share-button');
        foreach ($fbShares as $itemFbShare) {
            $itemFbShare->outertext = '';
        }
        $zaloShares = $contentDom->find('.zalo-share-button');
        foreach ($zaloShares as $itemZaloShare) {
            $itemZaloShare->outertext = '';
        }
        
        $adsBoxs = $contentDom->find('.ads.txt-center');
        foreach ($adsBoxs as $itemAdsBox) {
            $itemAdsBox->outertext = '';
        }
        $inputCsrf = $contentDom->find('input[name=_csrf]');
        foreach ($inputCsrf as $itemInputCsrf) {
            $itemInputCsrf->outertext = '';
        }
        $listDaterangePicker = $contentDom->find('#statisticform-fromdate');
        foreach ($listDaterangePicker as $itemDaterangePicker) {
            $itemDaterangePicker->setAttribute('data-krajee-daterangepicker','daterangepickerOption');
        }
        // clear Link
        $listATag = $contentDom->find('a');
        foreach ($listATag as $itemA) {
            if (\Str::contains($itemA->href,'youtube')) {
                $itemA->outertext = '';
            }else{
                $itemA->href = $this->clearLink($itemA->href);
            }
        }
        $listFormTag = $contentDom->find('form');
        foreach ($listFormTag as $itemForm) {
            $itemForm->action  = $this->clearLink($itemForm->action);
        }
        $listFaceBookComment = $contentDom->find('#comment');
        foreach ($listFaceBookComment as $itemFaceBookComment) {
            $itemFaceBookComment->setAttribute('data-href',$this->clearLink($itemFaceBookComment->getAttribute('data-href')));
        }
        // Clear list h3 của link youtube
        $listH3 = $contentDom->find('h3');
        foreach ($listH3 as $key => $itemH3) {
            if (\Str::contains($itemH3->id,'quay_thu_dai_')) {
                $itemH3->outertext = '';
            }
        }
        $contentDom = str_get_html($contentDom->innertext);

        // Save img In content
        $listImgs = $contentDom->find('img');
        foreach ($listImgs as $itemImg) {
            $imgSrc = $itemImg->attr['src'] ?? '';
            if (!\Str::contains($imgSrc,'http')) {
                $imgSrc = $itemImg->attr['data-src'] ?? '';
            }
            if (\Str::contains($imgSrc,'http')) {
                $itemImg->src = $this->saveImg($imgSrc, $this->imageSaveDir, true);
                $itemImg->removeAttribute('data-src');
            }else{
                $itemImg->outertext = '';
            }
        }
        $content = $this->clearContent($contentDom->innertext);
        return $content;
    }
    public function startCrawl()
    {
        return true;
    }
}
