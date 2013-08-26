<?php

namespace application\controllers;

use Imagine\Filter\Basic\Thumbnail;

use application\models\File;

class Files extends \Framework\Shared\Controller {
	
	public function thumbnails($id)
	{
		$path = APP_PATH . "/public/uploads";
		
		$file = File::first(array(
			"id = ?" => $id
		));
		
		if ($file) 
		{
			$width = 64;
			$height = 64;
			
			$name = $file->name;
			$filename = pathinfo($name, PATHINFO_FILENAME);
			$extension = pathinfo($name, PATHINFO_EXTENSION);
			
			if ($filename && $extension)
			{
				$thumbnail = "{$filename}-{$width}x{$height}.{$extension}";
				
				if (!file_exists("{$path}/{$thumbnail}"))
				{
					$imagine = new \Imagine\Gd\Imagine();
					
					$size = new \Imagine\Image\Box($width, $height);
					$mode = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
					$imagine
						->open("{$path}/{$name}")
						->thumbnail($size, $mode)
						->save("{$path}/{$thumbnail}");
					
				}
				
				header("Location: /uploads/{$thumbnail}");
				exit();
			}
			
			header("Location: /uploads/{$name}");
			exit();
		}
	}
}

