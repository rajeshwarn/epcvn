<?php
class Admin_Form_Validators_ArticleValid {
	public $message;
	
	public function __construct($data) {
		$val = new Zend_Validate_NotEmpty();
		if(!$val->isValid($data['titleEn']))
			$this->message[] = "Title is not empty";
		if(!$val->isValid($data['aliasEn']))
			$this->message[] = "Alias is not empty";
		if(!$val->isValid($data['introEn']))
			$this->message[] = "Introduction is not empty";
		if(!$val->isValid($data['contentEn']))
			$this->message[] = "Content is not empty";
		if(!$val->isValid($data['weight']))
			$this->message[] = "Order is not empty";
	}
	
	public function isValid() {
		if($this->message != "")
			return false;
		else
			return true;
	}
}