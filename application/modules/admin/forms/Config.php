<?php
class Admin_Form_Config extends Zend_Form {
	
	public function __construct($options = null){
		parent::__construct($options);
		
		$value = new Zend_Form_Element_Textarea('value');
		$value->setAttrib('class', 'product-seo')
				->setAttrib('id', 'tbvalue')
				->setAttrib('COLS', '40')
				->setAttrib('class', 'form-control')
				->setAttrib('ROWS', '4')
				->setDecorators(array('ViewHelper'));
		$arrElement = array(
				$value
		);
		$this->addElements($arrElement);
	}
}