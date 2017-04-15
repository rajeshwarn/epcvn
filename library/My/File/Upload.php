<?php 
class My_File_Upload extends Zend_File_Transfer_Adapter_Http{

   /**
    * @name upload
    * @example
    * $options = array(
         'prefix' => 'img_',
         'rename' => true,
         'override' => false,
         );
      $fileName = $upload->upload(ROOT_PATH.'/public/files','image',$options);
      
    */
   public function upload($destination = null, $file_upload = null, $options = null){
      
      $this->setDestination($destination,$file_upload);
      $fileName = $this->getFileName($file_upload,false);

      if(!empty($options['prefix'])){
         $fileName = $options['prefix'].$fileName;
      }
      
      if($options['rename'] == true){
         $tmp = preg_match('#\.[^.]+$#', $fileName,$match);
         $ext = $match[0];
         $name = substr($fileName, 0, strlen($fileName)-strlen($ext));
         
         $filter = new My_Filter_RemoveCircumflex();
         $name = $filter->filter($name);

         $fileName = $name.$ext;
         
         if(file_exists($destination .'/' . $fileName) && $options['override'] == false){
            $fileName = $name . '_' . time() . $ext;
         }
      }
      
      $this->addFilter('Rename',array('target'=>$fileName),$file_upload);
      $this->receive($file_upload);

      return $fileName;
   }

   public function remove($destination = null, $file_name = null){
      $filter = new Zend_Filter_PregReplace(array('match'=>'#[/]{2,}#','replace'=>'/'));
      $removeFile = $destination . '/' . $file_name;
      $removeFile = $filter->filter($removeFile);
      @unlink($removeFile);
   }
}