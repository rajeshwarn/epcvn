<?php

class My_File_Uploads extends Zend_File_Transfer_Adapter_Http{

    public function upload($file_name, $upload_dir, $options = null, $prefix = '') {

        if ($options == null) {       
            $this->setDestination(UPLOAD_PATH.'/'.$upload_dir.'/', $file_name);
            $info = $this->getFileInfo($file_name);
            $newFileName = $info[$file_name]['name'];
            $this->receive();            
        }else{ 
	        if ($options['task'] == 'rename') {
	        	$info = $this->getFileName($file_name);
	        	$this->setDestination(UPLOAD_PATH.'/'.$upload_dir.'/', $file_name);
	        	//$this->addValidator("Extension", false, array("jpg", "jpeg", "png", "pds", "gif", "bmp"));
	        	preg_match('#\.([^\.]+)$#',$info,$matches);
	        	$fileExtension  = $matches[1];
	        	$fileName = My_Common::standardURL(pathinfo($info, PATHINFO_FILENAME));
	        	$newFileName = $prefix . $fileName.'-'.time() . '.' . $fileExtension;
	        	
	        	$option = array('target' => UPLOAD_PATH.'/'. $upload_dir . '/' . $newFileName, 'overwrite'=>true);
	        	$this->addFilter('Rename',$option,$file_name);
	        	
	        	$this->receive($file_name);   
	        }
	        
	        if($options['isThumb']){
	        	My_File_Images::doThumbs('/' . $upload_dir . '/' . $newFileName, '/'.$upload_dir . '/small/', PRODUCT_WIDTH_SMALL, PRODUCT_WIDTH_SMALL);
	        	My_File_Images::doThumbs('/' . $upload_dir . '/' . $newFileName, '/'.$upload_dir . '/thumbs/', PRODUCT_WIDTH_THUMBS, PRODUCT_WIDTH_THUMBS);
	        }
        }

        return $newFileName;
    }

    public static function removeFile($filename) {
    	//echo $filename;exit;
        @unlink($filename);
    }

}