<?php

class My_File_Images {
	
    public static function doThumbs($fileName, $path, $w, $h, $crop = FALSE) {
        $file = UPLOAD_PATH . $fileName;
        $fileNameNew = basename($fileName);
        
        list($width, $height, $type) = getimagesize($file);
        $r = $width / $height;

        if ($crop) {
            if ($width > $height) {
                $width = ceil($width - ($width * ($r - $w / $h)));
            } else {
                $height = ceil($height - ($height * ($r - $w / $h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w / $h > $r) {
                $newwidth = $h * $r;
                $newheight = $h;
            } else {
                $newheight = $w / $r;
                $newwidth = $w;
            }
        }

        if ($type == 1) {
            $src = imagecreatefromgif($file);
        } elseif ($type == 2) {
            $src = imagecreatefromjpeg($file);
        } elseif ($type == 3) {
            $src = imagecreatefrompng($file);
        }

        $dst = imagecreatetruecolor($newwidth, $newheight);

        if ($type == 3) {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);

            // Fill the image with transparent color
            $color = imagecolorallocatealpha($dst, 0x00, 0x00, 0x00, 127);
            imagefill($dst, 0, 0, $color);
        }

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        if ($type == 1) {
            imagegif($dst, UPLOAD_PATH . $path . $fileNameNew, 100);
        } elseif ($type == 2) {
            imagejpeg($dst, UPLOAD_PATH . $path . $fileNameNew, 100);
        } elseif ($type == 3) {
            imagepng($dst, UPLOAD_PATH . $path . $fileNameNew, 100);
        }
    }
    
    public static function getThumbs($path){
    	$image = $path;
    	$info = getimagesize($image);
    	
    	header("Content-type: ".$info['mime']) ;
    	echo file_get_contents($image);
    	exit(0);
    }

}