<?php
class Admin_Form_Validators_CustomerValid {
	public $message;
	
	public function __construct($data) {
		$val = new Zend_Validate_NotEmpty();
		$val1 = new Zend_Validate_EmailAddress();
		$val2 = new Zend_Validate_Date();
		$val3 = new Zend_Validate_Digits();
		if(!$val->isValid($data['email']))
			$this->message[] = "Email is not empty";
		if(!$val->isValid($data['password']))
			$this->message[] = "Password is not empty";
		if(!$val->isValid($data['fullname']))
			$this->message[] = "Fulllname is not empty";
		if(!$val->isValid($data['birthday']))
			$this->message[] = "Birthday is not empty";
		if(!$val->isValid($data['address']))
			$this->message[] = "Address is not empty";
		if(!$val1->isValid($data['email']))
			$this->message[] = "Email error";
		if(!$val3->isValid($data['phone']))
			$this->message[] = "Phone error";
		/*if(!$val2->isValid($data['birthday']))
			$this->message[] = "Birthday error";*/
	}
	
	public function isValid() {
		if($this->message != "")
			return false;
		else
			return true;
	}
}