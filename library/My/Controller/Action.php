<?php

class My_Controller_Action extends Zend_Controller_Action {
	
	public function init() {
        /* $template_path = TEMPLATE_PATH . "/admin/system";
          $this->loadTemplate($template_path,'template.ini','template'); */
               
    }

    protected function loadTemplate($template_path, $fileConfig = 'template.ini', $sectionConfig = 'template') {
        $ssLang = new Zend_Session_Namespace('ssLang');
        //Xoa nhung du cua layout truoc
        $this->view->headTitle()->set('');
        $this->view->headMeta()->getContainer()->exchangeArray(array());
        $this->view->headLink()->getContainer()->exchangeArray(array());
        $this->view->headScript()->getContainer()->exchangeArray(array());

        $filename = $template_path . "/" . $fileConfig;
        $section = $sectionConfig;
        $config = new Zend_Config_Ini($filename, $section);
        $config = $config->toArray();

        $baseUrl = $this->_request->getBaseUrl();
        $templateUrl = $baseUrl . $config['url'];
        $cssUrl = $templateUrl . $config['dirCss'];
        $jsUrl = $templateUrl . $config['dirJs'];
        $imgUrl = $templateUrl . $config['dirImg'];
        
        $module = $this->getParam('module');
        
        
        //Nap cac the meta vao layout
        if (count($config['metaHttp']) > 0) {
            foreach ($config['metaHttp'] as $key => $value) {
                $tmp = explode("|", $value);
                $this->view->headMeta()->appendHttpEquiv($tmp[0], $tmp[1]);
            }
        }
		
		$tmp = $this->getConfig();
        Zend_Registry::set('config', $tmp);
        	
        if($module === 'default'){        	
        	$this->view->headTitle($tmp['title'.$ssLang->key]);
        	$this->view->headMeta()->appendName('keywords', $tmp['keywords']);
        	$this->view->headMeta()->appendName('description', $tmp['description']);
        }else{
        	//Nap title cho layout
        	$this->view->headTitle($config['title']);
        	 
        	if (count($config['metaName']) > 0) {
        		foreach ($config['metaName'] as $key => $value) {
        			$tmp = explode("|", $value);
        			$this->view->headMeta()->appendName($tmp[0], $tmp[1]);
        		}
        	}
        }

        //Nap cac tap tin CSS vao layout
        if (count($config['fileCss']) > 0) {
            foreach ($config['fileCss'] as $key => $css) {
                $this->view->headLink()->appendStylesheet($cssUrl . $css, 'screen');
            }
        }

        //Nap cac tap tin javascript cho layout
        if (count($config['fileJs']) > 0) {
            foreach ($config['fileJs'] as $key => $js) {
                $this->view->headScript()->appendFile($jsUrl . $js, 'text/javascript');
            }
        }

        $this->view->templateUrl = $templateUrl;
        $this->view->cssUrl = $cssUrl;
        $this->view->jsUrl = $jsUrl;
        $this->view->imgUrl = $imgUrl;
        /* echo '<pre>';
          print_r($config);
          echo '</pre>'; */
        $option = array('layoutPath' => $template_path, 'layout' => $config['layout']);
        Zend_Layout::startMvc($option);
    }
    
    protected function getConfig(){
    	$configModel = new Default_Model_Config();
    	$configs = $configModel->getItem();
    	
    	 
    	foreach($configs as $key=>$item){
    		$config[$item['name']] = $item['value'];
    	}
    	
    	return $config;
    }

}