<?php

class Admin_UploadController extends My_Controller_Action {

    private $_params = '';
    private $_userId = '';

    public function init() {
        $template_path = TEMPLATE_PATH . "/admin";
        $this->loadTemplate($template_path, 'template.ini', 'template');

        $this->_params = $this->_request->getParams();

        $auth = Zend_Auth::getInstance ();
        $infoUser = $auth->getIdentity ();
        $this->_userId = $infoUser ['userId'];
        //My_Auth_User::authenticate();
    }

    public function indexAction() {
        $template_path = TEMPLATE_PATH . "/admin";
        $this->loadTemplate($template_path, 'template.ini', 'ajax');
        $this->_helper->viewRenderer->setNoRender();
		
        $dir = $this->_params['dir'];
        $isThumb = $this->_params['thumb'];
        $featureDetailId = $this->_params['featureDetailId'];
        
        $file = new Zend_File_Transfer;
        $info = $file->getFileInfo();
        $name = $info['Filedata']['name'];
        $file->setDestination(UPLOAD_PATH . '/products/');
        $file->addValidator("Extension", false, array("jpg", "jpeg", "png", "pds", "gif", "bmp"));

        preg_match('#\.([^\.]+)$#', $name, $matches);
        $fileExtension = $matches[1];
        $fileName = My_Common::standardURL(pathinfo($name, PATHINFO_FILENAME));
        $newFileName = $fileName . '-' . time() . '.' . $fileExtension;
        $id = md5($newFileName + rand()*100000);
        
        //$_SESSION['image'][$fileId] = $newFileName;
        
        $options = array("target" => UPLOAD_PATH . '/'.$dir.'/' . $newFileName, "overwrite" => true);
        $file->addFilter("Rename", $options, "Filedata");
        $file->receive();
		
        if($isThumb){
	        My_File_Images::doThumbs('/'.$dir.'/' . $newFileName, '/'.$dir.'/small/', PRODUCT_WIDTH_SMALL, PRODUCT_WIDTH_SMALL);
	        My_File_Images::doThumbs('/'.$dir.'/' . $newFileName, '/'.$dir.'/thumbs/', PRODUCT_WIDTH_THUMBS, PRODUCT_WIDTH_THUMBS);
        }
        
        $tmpModel = new Admin_Model_Tmp();
        
        $data = array(
        	'id' => $id,
        	'fileName' => $newFileName,        	
        	'userId' => $this->_userId,
        	'featureDetailId' => $featureDetailId
        );
        
        $tmpModel->addItem($data);
                
        echo "FILEID:" . $id;	
        exit(0);
    }
    
    function getThumbProductAction(){
    	$tmpModel = new Admin_Model_Tmp();
    	$tmp = $tmpModel->getTmpOne($this->_params['id']);
    	
    	$path = UPLOAD_PATH.'/products/thumbs/'.$tmp['fileName'];
    	My_File_Images::getThumbs($path);
    }

    function ajaxDeleteAction() {
        $template_path = TEMPLATE_PATH . "/admin";
        $this->loadTemplate($template_path, 'template.ini', 'ajax');
        $this->_helper->viewRenderer->setNoRender();

        $id = $this->_params['id'];
        
        $tmpModel = new Admin_Model_Tmp();
        $tmp = $tmpModel->getTmpOne($id);
        
        $fileName = UPLOAD_PATH . '/products/' . $tmp['fileName'];
        $fileNameSmall = UPLOAD_PATH . '/products/small/' . $tmp['fileName'];
        $fileNameThumb = UPLOAD_PATH . '/products/thumbs/' . $tmp['fileName'];

        My_File_Upload::removeFile($fileName);
        My_File_Upload::removeFile($fileNameSmall);
        My_File_Upload::removeFile($fileNameThumb);
        
        $result = $tmpModel->deleteItem($id);
        
        echo $result;
        die;
    }

}