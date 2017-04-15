<?php
class Admin_Form_Validators_EnquiryValid {
	public $message;
	
	public function __construct($data) {
		$val = new Zend_Validate_NotEmpty();
		$val1 = new Zend_Validate_EmailAddress();
		if(!$val->isValid($data['firstName']))
			$this->message[] = "FirstName is not empty";
		if(!$val->isValid($data['lastName']))
			$this->message[] = "LastName is not empty";
		if(!$val->isValid($data['email']))
			$this->message[] = "Email is not empty";
	}
	
	public function isValid() {
		if($this->message != "")
			return false;
		else
			return true;
	}
}