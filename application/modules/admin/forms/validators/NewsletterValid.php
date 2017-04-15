<?php
class Admin_Form_Validators_NewsletterValid {
	public $message;
	
	public function __construct($data) {
		$val = new Zend_Validate_NotEmpty();
		if(!$val->isValid($data['from']))
			$this->message[] = "From is not empty";
		if(!$val->isValid($data['title']))
			$this->message[] = "Title is not empty";
		if(!$val->isValid($data['content']))
			$this->message[] = "Content is not empty";
	}
	
	public function isValid() {
		if($this->message != "")
			return false;
		else
			return true;
	}
}