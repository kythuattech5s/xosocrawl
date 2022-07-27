<?php

namespace App\Helpers;

use vanhenry\manager\model\Media;
use WebPConvert\WebPConvert;

class MediaHelper
{
	const ROOT = 'public/uploads/';
	// eg: $folder = users
	public static function insertFileFromUrl($folder, $url)
	{
		if (!preg_match('/^[a-z0-9]+$/', $folder)) {
			throw new \Exception("Tên thư mục chỉ được chứa các ký tự [a-z0-9]");
		}
		$fileContent = \Support::exeCurl($url);
		if (empty($fileContent)) {
			return;
		}
		$fileExtension = strtolower(substr($url, strrpos($url, '.') + 1));
		if (!in_array($fileExtension, config('manager.ext_img'))) {
			$fileExtension = '.jpg';
		}
		$filePathAbsolute = self::ROOT.$folder.'/';
		$parent = self::getOrSetParent($folder, $filePathAbsolute);
		$fileName = time().'_'.uniqid();
		$fileFullName = $fileName.'.'.$fileExtension;
		$fileFullPath = $filePathAbsolute.$fileFullName;
		file_put_contents($fileFullPath, $fileContent);
		WebPConvert::convert($fileFullPath, $filePathAbsolute.$fileName.'.webp', []);
		self::resizeImage($fileFullPath, $filePathAbsolute, $fileFullName, $fileName, $fileExtension);
		$media = self::insertMedia($fileFullPath, $filePathAbsolute, $fileFullName, $parent->id);
		if ($media == null) {
			return;
		}
		return $media->toJson();
	}
	public static function getOrSetParent($folder, $filePathAbsolute)
	{
		$parent = Media::where('name', $folder)->where('path', self::ROOT)->where('is_file', 0)->first();
		if ($parent == null) {
			if (!file_exists($filePathAbsolute)) {
				mkdir($filePathAbsolute, 765, true);
			}
			$parent = new Media;
			$parent->name = $folder;
			$parent->file_name = $folder;
			$parent->is_file = 0;
			$parent->parent = 0;
			$parent->path = self::ROOT;
			$parent->file_name = $folder;
			$extra['extension'] = '';
			$extra['size'] = self::human_filesize(filesize($filePathAbsolute));
			$extra['date'] = filemtime($filePathAbsolute);
			$extra['isfile'] = 0;
			$extra['dir'] = self::ROOT;
			$extra['path'] = $filePathAbsolute;
			$parent->extra = json_encode($extra);
			$parent->save();
		}
		else{
			if (!file_exists($filePathAbsolute)) {
				mkdir($filePathAbsolute, 765, true);
			}
		}
		return $parent;
	}
    public static function resizeImage($fileFullPath, $filePathAbsolute, $fileFullName, $fileName, $fileExtension)
    {
    	$resizeConfigs = \DB::table('v_configs')->select('value')->where('name', 'SIZE_IMAGE')->first();
    	$resizeConfigs = json_decode($resizeConfigs->value, true);
    	if ($resizeConfigs == null) {
    		return;
    	}
		$s = getimagesize($fileFullPath);
		$w = count($s)>0?$s[0]:1;
		$h = count($s)>1?$s[1]:1;
		array_push($resizeConfigs,array("name"=>"def","width"=>100,"height"=>(int)($h*100/$w),"quality"=>80));
    	foreach ($resizeConfigs as $kconfig => $config) {
			$interventionImg = \Image::make($fileFullPath);
			if ($config['height'] <= 0) {
				$interventionImg->resize($config['width'], null, function ($constraint) {
				    $constraint->aspectRatio();
				});
			}
			elseif($config['width'] <= 0){
				$interventionImg->resize(null, $config['height'], function ($constraint) {
				    $constraint->aspectRatio();
				});
			}
			else{
				$interventionImg->resize($config['width'], $config['height']);
			}
			if (substr($filePathAbsolute, -1) != '/') {
				$filePathAbsolute .= '/';
			}
			$uploadToResizeDir = $filePathAbsolute.'thumbs/'.$config['name'].'/';
			if(!is_dir($uploadToResizeDir)){
	        	mkdir($uploadToResizeDir, 765, true);
	        }
	        $interventionImg->save($uploadToResizeDir.$fileFullName, 100);
			if(in_array($fileExtension, ['jpg','jpeg','png'])){
				WebPConvert::convert($uploadToResizeDir.$fileFullName, $uploadToResizeDir.$fileName.'.webp', []);
			}
		}
    }
    public static function human_filesize($bytes, $decimals = 2) {
    	$sz = 'BKMGTP';
    	$factor = floor((strlen($bytes) - 1) / 3);
    	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . (" ".@$sz[$factor]."B");
    }
    public static function insertMedia($fileFullPath, $filePathAbsolute, $fileFullName, $parent){
		$m = new Media;
		$m->name = $fileFullName;
		$m->file_name = $fileFullName;
		$m->is_file = 1;
		$m->parent = $parent;
		$m->path = $filePathAbsolute;
		$m->extra = json_encode(self::getInfoFile($fileFullName, $fileFullPath));
		$m->save();
		\Event::dispatch('vanhenry.manager.media.insert.success', array($m->name, $m->id));
		return $m;
	}
	public static function getInfoFile($fileFullName, $fileFullPath){
		$extimgs = config("manager.ext_img");
		$extvideos = config("manager.ext_video");
		$extfiles =  config("manager.ext_file");
		$extmusic =  config("manager.ext_music");
		$extmisc =  config("manager.ext_misc");
		$publicPath = \Config::get("manager.public_path");
		$obj = new \stdClass();
		$obj->extension = strtolower(substr(strrchr($fileFullName,'.'),1));
		$obj->size= self::human_filesize(filesize($fileFullPath));
		$obj->date = filemtime($fileFullPath);
		$obj->isfile = is_file($fileFullPath)?1:0;
		$onlyDir =  substr($fileFullPath,0, strrpos($fileFullPath, "/")+1);
		$obj->dir= $onlyDir;
		$obj->path = $onlyDir.$fileFullName;
		if($obj->isfile){
			if(in_array($obj->extension, $extimgs)){
				$imagedetails = getimagesize($file_path);
				$obj->width = $imagedetails[0];
				$obj->height= $imagedetails[1];
			    if(file_exists($onlyDir.'thumbs/def/'.$filename)){
			    	$obj->thumb = $onlyDir.'thumbs/def/'.$filename;
			    }
			    else{
			    	$obj->thumb = $onlyDir.$filename;
			    }
			}
			else if(in_array($obj->extension, $extvideos)){
			    if(file_exists($publicPath."admin/images/ico/".$obj->extension.".jpg")){
			    	$obj ->thumb = $publicPath."admin/images/ico/".$obj->extension.".jpg";
			    }
			    else{
			    	$obj->thumb = $publicPath."admin/images/ico/file.jpg";
			    }
			}
			else if(in_array($obj->extension, $extfiles)){
			    if(file_exists($publicPath."admin/images/ico/".$obj->extension.".jpg")){
			    	$obj ->thumb = $publicPath."admin/images/ico/".$obj->extension.".jpg";
			    }
			    else{
			    	$obj->thumb = $publicPath."admin/images/ico/file.jpg";
			    }
			  }
			else if(in_array($obj->extension, $extmusic)){
			    if(file_exists($publicPath."admin/images/ico/".$obj->extension.".jpg")){
			    	$obj ->thumb = $publicPath."admin/images/ico/".$obj->extension.".jpg";
			    }
			    else{
			    	$obj->thumb = $publicPath."admin/images/ico/file.jpg";
			    }
			  }
			else if(in_array($obj->extension, $extmisc)){
			    if(file_exists($publicPath."admin/images/ico/".$obj->extension.".jpg")){
			    	$obj ->thumb = $publicPath."admin/images/ico/".$obj->extension.".jpg";
			    }
			    else{
			    	$obj->thumb = $publicPath."admin/images/ico/file.jpg";
			    }
		  	}
			else{
			  $obj->thumb = $publicPath."admin/images/ico/file.jpg";
			}
		}
		return $obj;
	}
    public static function uploadImgs(string $folder, string $field){
    	$results = collect();
    	if (!request()->hasFile($field)) {
    		return $results;
    	}
    	$parent = self::getOrSetParent($folder, self::ROOT.$folder.'/');
		$filePathAbsolute = self::ROOT.$folder.'/';
		$resizeConfigs = \DB::table('v_configs')->select('value')->where('name', 'SIZE_IMAGE')->first();
		$images = request()->file($field);
		if (is_object($images)) {
			$fileExtension = $images->getClientOriginalExtension();
			$fileName = time().'_'.uniqid();
			$fileFullName = $fileName.'.'.$fileExtension;
			$fileFullPath = $filePathAbsolute.$fileFullName;
			$images->move($filePathAbsolute, $fileFullName);
			WebPConvert::convert($fileFullPath, $filePathAbsolute.$fileName.'.webp', []);
			self::resizeImage($fileFullPath, $filePathAbsolute, $fileFullName, $fileName, $fileExtension);
			$results->push(self::insertMedia($fileFullPath, $filePathAbsolute, $fileFullName, $parent->id));
		}
		else{
			foreach ($images as $key => $image) {
				$fileExtension = $image->getClientOriginalExtension();
				$fileName = time().'_'.uniqid();
				$fileFullName = $fileName.'.'.$fileExtension;
				$fileFullPath = $filePathAbsolute.$fileFullName;
				$image->move($filePathAbsolute, $fileFullName);
				WebPConvert::convert($fileFullPath, $filePathAbsolute.$fileName.'.webp', []);
				self::resizeImage($fileFullPath, $filePathAbsolute, $fileFullName, $fileName, $fileExtension);
				$results->push(self::insertMedia($fileFullPath, $filePathAbsolute, $fileFullName, $parent->id));
			}
		}
		return $results;
    }
}