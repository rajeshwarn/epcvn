<?php
class Admin_Form_Validators_UserValid {
	public $message;
	
	public function __construct($data) {
		$val = new Zend_Validate_NotEmpty();
		$val1 = new Zend_Validate_EmailAddress();
		if(!$val->isValid($data['email']))
			$this->message[] = "Email is not empty";
		if(!$val->isValid($data['password']))
			$this->message[] = "Password is not empty";
		if(!$val->isValid($data['fullname']))
			$this->message[] = "Fulllname is not empty";
		if(!$val->isValid($data['userName']))
			$this->message[] = "UserName is not empty";
		if(!$val1->isValid($data['email']))
			$this->message[] = "Email error";
	}
	
	public function isValid() {
		if($this->message != "")
			return false;
		else
			return true;
	}
}