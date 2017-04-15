<?php
class Admin_Form_Support extends Zend_Form {
	
	public function __construct($options = null){
		parent::__construct($options);
		
		$nameVi = new Zend_Form_Element_Text('nameVi');
		$nameVi->addFilter('StringTrim')
				->setRequired(true)
				->addValidator('NotEmpty')
				->setAttrib('class', 'form-control')
				->setDecorators(array('ViewHelper'));
		
		$regencyVi = new Zend_Form_Element_Text('regencyVi');
		$regencyVi->addFilter('StringTrim')
				->setRequired(true)
				->addValidator('NotEmpty')
				->setAttrib('class', 'form-control')
				->setDecorators(array('ViewHelper'));
		
		$phone = new Zend_Form_Element_Text('phone');
		$phone->addFilter('StringTrim')
		->setAttrib('class', 'form-control')
		->setDecorators(array('ViewHelper'));
		
		$fax = new Zend_Form_Element_Text('fax');
		$fax->addFilter('StringTrim')
		->setAttrib('class', 'form-control')
		->setDecorators(array('ViewHelper'));
		
		$mobile = new Zend_Form_Element_Text('mobile');
		$mobile->addFilter('StringTrim')
		->setAttrib('class', 'form-control')
		->setDecorators(array('ViewHelper'));
		
		$email = new Zend_Form_Element_Text('email');
		$email->addFilter('StringTrim')
		->setAttrib('class', 'form-control')
		->setDecorators(array('ViewHelper'));
		
		$yahoo = new Zend_Form_Element_Text('yahoo');
		$yahoo->addFilter('StringTrim')
		->setAttrib('class', 'form-control')
		->setDecorators(array('ViewHelper'));
		
		$skype = new Zend_Form_Element_Text('skype');
		$skype->addFilter('StringTrim')
		->setAttrib('class', 'form-control')
		->setDecorators(array('ViewHelper'));

		$weight = new Zend_Form_Element_Text('weight');
		$weight->addFilter('StringTrim')
			->setRequired(true)
			->addValidator('NotEmpty')
			->setAttrib('class', 'form-control')
			->setValue('999')
			->setDecorators(array('ViewHelper'));
		$status = new Zend_Form_Element_Radio('status');
		$status->addFilter('StringTrim')
			->setAttrib('class', 'grey')
			->setMultiOptions(array('1' => "Có",'0' => "Không"))
			->setValue('1')
			->setDecorators(array('ViewHelper'));
		
		$hotline = new Zend_Form_Element_Radio('hotline');
		$hotline->addFilter('StringTrim')
		->setAttrib('class', 'grey')
		->setMultiOptions(array('1' => "Có",'0' => "Không"))
		->setValue('0')
		->setDecorators(array('ViewHelper'));
		$arrElement = array(
				$nameVi,
				$regencyVi,
				//$phone,
				$fax,
				$mobile,
				$email,
				$yahoo,
				$skype,
				$weight,
				$hotline,
				$status
		);
		
		if(ENGLISH == 1){
			$nameEn = new Zend_Form_Element_Text('nameEn');
			$nameEn->addFilter('StringTrim')
			->setRequired(true)
			->addValidator('NotEmpty')
			->setAttrib('class', 'form-control')
			->setDecorators(array('ViewHelper'));
			
			$regencyEn = new Zend_Form_Element_Text('regencyEn');
			$regencyEn->addFilter('StringTrim')
			->setRequired(true)
			->addValidator('NotEmpty')
			->setAttrib('class', 'form-control')
			->setDecorators(array('ViewHelper'));
			
			$arrElement[] = $nameEn;
			$arrElement[] = $regencyEn;
		}
			
		$this->addElements($arrElement);
	}
}