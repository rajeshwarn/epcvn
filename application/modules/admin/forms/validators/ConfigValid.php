<?php
class Admin_Form_Validators_ConfigValid {
	public $message;
	
	public function __construct($data) {
		$val = new Zend_Validate_NotEmpty();
		if(!$val->isValid($data['name']))
			$this->message[] = "Name is not empty";
	}
	
	public function isValid() {
		if($this->message != "")
			return false;
		else
			return true;
	}
}