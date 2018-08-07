<?php

function get_cache_file_path($file, $w, $h) {
    $file = realpath($file);
    $path_info = pathinfo($file);
    return str_replace(GALLERY_PATH, GALLERY_CACHE_PATH, $path_info['dirname']) . DIRECTORY_SEPARATOR . $path_info['filename'] . $w . 'X' . $h . '.' . $path_info['extension'];
}


function image_downlowdable_sizes($file){
    try{
        $image = new Imagick($file);
        $exifArray = $image->identifyImage();
       
        $width = $exifArray['geometry']['width'];
        $height = $exifArray['geometry']['height'];
        return [
            50=>[
                'label'=>'50%',
                'width'=> round(($width - ($width*50/100)),0),
                'height'=> round(($height - ($height*50/100)),0)
            ],
            70=>[
                'label'=>'70%',
                'width'=> round(($width - ($width*30/100)),0),
                'height'=> round(($height - ($height*30/100)),0)
            ],
            100=>[
                'label'=>'Full',
                'width'=> ($width),
                'height'=> ($height)
            ]
        ];
    }catch(Exception $e){
        return [];
    }
    
}

function create_file($file,$target, $size,$backgroundColor='#fff'){
    list($w, $h) = $size;
   
    $path_info = pathinfo($file);
    try{
        $image = new Imagick($file);
        $image->scaleImage($w, $h, false);
        //$image->thumbnailimage($w, $h, true,true);
        //$image->cropthumbnailimage($w, $h);
        $image->setImageFormat($path_info['extension']);
//        if($path_info['extension'] != 'tif'){
//            $old_w = $image->getimagewidth();
//            $old_h = $image->getimageheight();
//
//            $xpos = (int)abs(($old_w-$w) / 2);
//            $ypos = (int)abs(($old_h-$h) / 2);
//
//            $new_image = new Imagick();
//            $new_image->newImage($w,$h, $backgroundColor);
//            $new_image->setImageFormat($path_info['extension']);
//
//            $new_image->compositeimage($image->getimage(), Imagick::COMPOSITE_COPY, $xpos, $ypos);
//            
//            $image = $new_image;
//        }
        //$old_image->getImageBlob();
        
        
    } catch (Exception $e){
        
       $image = get_empty_file('gray','white','gray',$w, $h);
       
    }
    
    $dirname = dirname($target);
    if (!is_dir($dirname)) {
        mkdir($dirname, 0755, true);
    }
    $image->writeImage($target);

    return $target;
}

function get_cache_file($file, $size) {

    list($w, $h) = $size;

    $cache_file = get_cache_file_path($file, $w, $h);
    //return create_file($file, $cache_file,$size);
    
    if (file_exists($cache_file)) {
        return $cache_file;
    } else {
        return create_file($file, $cache_file,$size);
    }
}

function get_file($file, $size) {
    try {
        //list($w, $h) = $size;
        //resize($file, $w, $h);
        
        if (!empty($size)) {
            $file = get_cache_file($file, $size);
            $image = new Imagick($file);
            $image->setImageFormat('png');
            
        } else {
            $image = new Imagick($file);
            $image->setImageFormat('png');
            list($w, $h) = array_values($image->getImageGeometry());
            $image->scaleImage($w, $h, true);
        }

        header("Content-Type: image/jpg");
        echo $image->getImageBlob();
    } catch (Exception $e) {
       header("Content-Type: image/png");
       $img =  get_empty_file('gray','white','gray');
       echo $img->getImageBlob();
    }
}

function get_empty_file($strokeColor, $fillColor, $backgroundColor,$w=70,$h=100){

    $draw = new \ImagickDraw();
    $p = 5; //padding
    $draw->setStrokeOpacity(1);
    $draw->setStrokeColor($strokeColor);
    $draw->setFillColor($fillColor);

    $draw->setStrokeWidth(2);
    $draw->setFontSize(($w/2)-2);

    $draw->pathStart();
    $draw->pathMoveToAbsolute($p, $p);
    $draw->pathLineToAbsolute($w-$p, $p);
    $draw->pathLineToAbsolute($w-$p, $h-$p);
    $draw->pathLineToAbsolute($p, $h-$p);
    $draw->pathLineToAbsolute($p, $p);
    $draw->pathFinish();
    
    $imagick = new \Imagick();
    $imagick->newImage($w,$h, $backgroundColor);
    $imagick->setImageFormat("png");
    
    $imagick->drawImage($draw);
    
    $x_center = $w/2 - ($w/2)+5;
    $y_center = $h/2 +10;
    $imagick->annotateImage($draw, $x_center, $y_center, 0, 'img');

   // header("Content-Type: image/png");
    return  $imagick;
}


function resize($filename, $width, $height) {
		if (!is_file($filename) ) {
			return;
		}
                //$ci =& get_instance();
                //$ci->load->helper('utf8');
                
		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		$image_old = $filename;
		$image_new = get_cache_file_path($filename,$width, $height);
                        //'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . (int)$width . 'x' . (int)$height . '.' . $extension;

		if (!is_file($image_new) || (filemtime($image_old) > filemtime($image_new))) {
			list($width_orig, $height_orig, $image_type) = getimagesize($image_old);
				 
			if (!in_array($image_type, array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF,IMAGETYPE_TIFF_II,IMAGETYPE_TIFF_MM))) { 
				return $image_old;
			}
						
			$path = '';

			$directories = explode('/', dirname($image_new));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir($path)) {
					@mkdir($path, 0777);
				}
			}

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image($image_old);
				$image->resize($width, $height);
				$image->save($image_new);
			} else {
				copy($image_old,$image_new);
			}
		}
		
		$image_new = str_replace(' ', '%20', $image_new);  // fix bug when attach image on email (gmail.com). it is automatic changing space " " to +
		echo $image_new;
                die;
		
	}




function resizeImage($imagePath, $width, $height, $filterType, $blur, $bestFit, $cropZoom) {
    //The blur factor where &gt; 1 is blurry, &lt; 1 is sharp.
    $imagick = new \Imagick(realpath($imagePath));
    if ($imagick->getImageFormat() == 'TIFF') {
        get_file($imagePath, [$width, $height]);
        die;
    }
    $imagick->setImageFormat('png');
    $imagick->resizeImage($width, $height, $filterType, $blur, $bestFit);

    $cropWidth = $imagick->getImageWidth();
    $cropHeight = $imagick->getImageHeight();

    if ($cropZoom) {
//        $newWidth = $cropWidth / 2;
//        $newHeight = $cropHeight / 2;
//
//        $imagick->cropimage(
//            $newWidth,
//            $newHeight,
//            ($cropWidth - $newWidth) / 2,
//            ($cropHeight - $newHeight) / 2
//        );

        $imagick->scaleimage(
                $imagick->getImageWidth() * 4, $imagick->getImageHeight() * 4
        );
    }


    header("Content-Type: image/jpg");
    echo $imagick->getImageBlob();
}
