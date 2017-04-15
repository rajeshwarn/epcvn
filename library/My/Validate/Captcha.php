<?php
class My_Validate_Captcha extends Zend_Validate_Abstract{

	const NOT_EQUAL = 'notCaptchaEqual';
	
	protected $_captchaID;
   	 
    protected $_messageTemplates = array(
        self::NOT_EQUAL => "Captcha incorrect",
        
    );

    public function __construct($captchaID){
    	$this->_captchaID = $captchaID;
    	
    }
    
    public function isValid($value){
    	$captchaSession = new Zend_Session_Namespace('Zend_Form_Captcha_' . $this->_captchaID);
    	
    	if(strcmp($value,$captchaSession->word) != 0){
    		$this->_error('notCaptchaEqual');
    		return false;    		
    	}
    	
    	return true;
    	
    }
}