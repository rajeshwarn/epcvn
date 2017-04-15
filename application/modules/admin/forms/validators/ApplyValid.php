<?php
class Admin_Form_Validators_ApplyValid {
	public $message;
	
	public function __construct($data) {
		$val = new Zend_Validate_NotEmpty();
		$val1 = new Zend_Validate_EmailAddress();
		$val2 = new Zend_Validate_Digits();
		if(!$val->isValid($data['firstName']))
			$this->message[] = "FirstName is not empty";
		if(!$val->isValid($data['lastName']))
			$this->message[] = "LastName is not empty";
		if(!$val->isValid($data['email']))
			$this->message[] = "Email is not empty";
		if(!$val->isValid($data['age']))
			$this->message[] = "Age is not empty";
		if(!$val->isValid($data['major']))
			$this->message[] = "Major is not empty";
		if(!$val1->isValid($data['email']))
			$this->message[] = "Email Error";
		if(!$val2->isValid($data['age']))
			$this->message[] = "Age Error";
	}
	
	public function isValid() {
		if($this->message != "")
			return false;
		else
			return true;
	}
}