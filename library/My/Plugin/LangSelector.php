<?php
class My_Plugin_LangSelector extends Zend_Controller_Plugin_Abstract{
 
	public function preDispatch(Zend_Controller_Request_Abstract $request){
		$ssLang = new Zend_Session_Namespace('ssLang');
		$locale = Zend_Registry::get('Zend_Locale');
		$lang = $request->getParam('l', '');
		
		if($lang != ''){
			$ssLang->key = ucfirst($lang);
		}else{
			if(!isset($ssLang->key)){
				$ssLang->key = ucfirst($locale);
			}
		}
		
		$langLocale = isset($ssLang->key) ? strtolower($ssLang->key) : $locale;
		
		$zl = new Zend_Locale();
		$zl->setLocale(strtolower($langLocale));
		Zend_Registry::set('Zend_Locale', $zl);
		
		$tranlate = new Zend_Translate("Array", APPLICATION_PATH."/languages/".$langLocale.".php", $langLocale);
		Zend_Registry::set('Zend_Translate', $tranlate);

		$baseUrl = new Zend_View_Helper_BaseUrl();
		
		//$url = Zend_Controller_Front::getInstance()->getRequest()->getHeader('REFERER');
		//echo $url;  
		//$this->getResponse()->setRedirect($url);
    }
}

