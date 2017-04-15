<?php
class Admin_Form_Validators_SlideshowValid {
	public $message;
	
	public function __construct($data) {
		$val = new Zend_Validate_NotEmpty();
		if(!$val->isValid($data['title']))
			$this->message[] = "Title is not empty";
		if(!$val->isValid($data['website']))
			$this->message[] = "Website is not empty";
	}
	
	public function isValid() {
		if($this->message != "")
			return false;
		else
			return true;
	}
}