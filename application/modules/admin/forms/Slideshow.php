<?php
class Admin_Form_Slideshow extends Zend_Form {
	
	public function __construct($options = null){
		parent::__construct($options);
		
		$titleVi = new Zend_Form_Element_Text('titleVi');
		$titleVi->addFilter('StringTrim')
				->setRequired(true)
				->addValidator('NotEmpty')
				->setAttrib('class', 'form-control')
				->setDecorators(array('ViewHelper'));
		$titleEn = new Zend_Form_Element_Text('titleEn');
		$titleEn->addFilter('StringTrim')
				->setRequired(true)
				->addValidator('NotEmpty')
				->setAttrib('class', 'form-control')
				->setDecorators(array('ViewHelper'));
		$introVi = new Zend_Form_Element_Textarea('introVi');
		$introVi->setAttrib('id', 'tbintroEn')
			 	->setAttrib('COLS', '40')
			 	->setAttrib('class', 'form-control')
			 	->setAttrib('ROWS', '4')
			 	->setDecorators(array('ViewHelper'));
		$introEn = new Zend_Form_Element_Textarea('introEn');
		$introEn->setAttrib('id', 'tbintroEn')
				->setAttrib('COLS', '40')
				->setAttrib('class', 'form-control')
				->setAttrib('ROWS', '4')
				->setDecorators(array('ViewHelper'));
		$website = new Zend_Form_Element_Text('website');
		$website->setAttrib('class', 'form-control')
				->setDecorators(array('ViewHelper'));
		$imageAlt = new Zend_Form_Element_Text('imageAlt');
		$imageAlt->setAttrib('class', 'form-control')
				->setDecorators(array('ViewHelper'));
				
		$status = new Zend_Form_Element_Radio('status');
		$status->addFilter('StringTrim')
				->setAttrib('class', 'grey')
				->setMultiOptions(array('1' => "Có",'0' => "Không"))
				->setValue('1')
				->setDecorators(array('ViewHelper'));
		$weight = new Zend_Form_Element_Text('weight');
		$weight->addFilter('StringTrim')
				->setRequired(true)
				->addValidator('NotEmpty')
				->setValue(999)
				->setAttrib('class', 'form-control')
				->setDecorators(array('ViewHelper'));
		$arrElement = array(
				$titleVi,
				$titleEn,
				$introVi,
				$introEn,
				$website,
				//$imageAlt,
				$status,
				$weight
		);
		$this->addElements($arrElement);
	}
}