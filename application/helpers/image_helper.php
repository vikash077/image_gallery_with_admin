<?php

function get_cache_file_path($file, $w, $h) {
    $file = realpath($file);
    $path_info = pathinfo($file);
    return str_replace(GALLERY_PATH, GALLERY_CACHE_PATH, $path_info['dirname']) . DIRECTORY_SEPARATOR . $path_info['filename'] . $w . 'X' . $h . '.' . $path_info['extension'];
}

function create_file($file,$target, $size){
    
    list($w, $h) = $size;
    
    $path_info = pathinfo($file);
    try{
        $image = new Imagick($file);
        $image->setImageFormat($path_info['extension']);
        $image->thumbnailImage($w, $h, false);
    } catch (Exception $e){
       $image = get_empty_file('gray','white','red',$w, $h);
       
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
    
    if (file_exists($cache_file)) {
        return $cache_file;
    } else {
        return create_file($file, $cache_file,$size);
    }
}

function get_file($file, $size) {
    try {
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
       $img =  get_empty_file('gray','white','red');
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