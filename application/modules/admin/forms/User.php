<?php
class Admin_Form_User extends Zend_Form {
	
	public function __construct($options = null){
		parent::__construct($options);
		
		$userName = new Zend_Form_Element_Text('userName');
		$userName->addFilter('StringTrim')
					->setRequired(true)
					->addValidator('NotEmpty')
					->setAttrib('class', 'form-control')
					->setDecorators(array('ViewHelper'));
		$email = new Zend_Form_Element_Text('email');
		$email->addFilter('StringTrim')
				->setRequired(true)
				->addValidator('NotEmpty')
				->setAttrib('class', 'form-control')
				->setDecorators(array('ViewHelper'));
		$password = new Zend_Form_Element_Password('password');
		$password->addFilter('StringTrim')
				->setRequired(true)
				->addValidator('NotEmpty')
				->setAttrib('class', 'form-control')
				->setDecorators(array('ViewHelper'));
		$fullname = new Zend_Form_Element_Text('fullname');
		$fullname->addFilter('StringTrim')
				->setRequired(true)
				->addValidator('NotEmpty')
				->setAttrib('class', 'form-control')
				->setDecorators(array('ViewHelper'));
		$status = new Zend_Form_Element_Radio('status');
		$status->addFilter('StringTrim')
				->setAttrib('class', 'grey')
				->setMultiOptions(array('1' => "Display",'0' => "Hide"))
				->setValue('1')
				->setDecorators(array('ViewHelper'));
		$arrElement = array(
				$userName,
				$email,
				$password,
				$fullname,
				$status
		);
		$this->addElements($arrElement);
	}
}