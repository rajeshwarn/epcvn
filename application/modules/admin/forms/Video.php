<?php
class Admin_Form_Video extends Zend_Form {
	
	public function __construct($options = null){
		parent::__construct($options);
		
		$youtube = new Zend_Form_Element_Text('youtube');
		$youtube->addFilter('StringTrim')
				->setRequired(true)
				->addValidator('NotEmpty')
				->setAttrib('class', 'form-control')
				->setDecorators(array('ViewHelper'));
		
		$weight = new Zend_Form_Element_Text('weight');
		$weight->addFilter('StringTrim')
			->setRequired(true)
			->addValidator('NotEmpty')
			->setAttrib('class', 'form-control')
			->setValue('1')
			->setDecorators(array('ViewHelper'));
		$status = new Zend_Form_Element_Radio('status');
		$status->addFilter('StringTrim')
			->setAttrib('class', 'grey')
			->setMultiOptions(array('1' => "Có",'0' => "Không"))
			->setValue('1')
			->setDecorators(array('ViewHelper'));
		$arrElement = array(
				$youtube,
				$weight,
				$status
		);
			
		$this->addElements($arrElement);
	}
}