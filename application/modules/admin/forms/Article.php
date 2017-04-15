<?php
class Admin_Form_Article extends Zend_Form {
	
	public function __construct($options = null){
		parent::__construct($options);
		
		$titleEn = new Zend_Form_Element_Text('titleEn');
		$titleEn->addFilter('StringTrim')
				->setRequired(true)
				->addValidator('NotEmpty')
				->setAttrib('class', 'form-control')
				->setDecorators(array('ViewHelper'));
		
		$aliasEn = new Zend_Form_Element_Text('aliasEn');
		$aliasEn->addFilter('StringTrim')
				->setRequired(true)
				->addValidator('NotEmpty')
				->setAttrib('class', 'form-control')
				->setDecorators(array('ViewHelper'));
		
		$introEn = new Zend_Form_Element_Textarea('introEn');
		$introEn->setAttrib('class', 'article-seo')
				 	->setAttrib('id', 'tbintroEn')
				 	->setAttrib('COLS', '40')
				 	->setAttrib('class', 'form-control')
				 	->setAttrib('ROWS', '4')
				 	->setDecorators(array('ViewHelper'));
		$contentEn = new Zend_Form_Element_Textarea('contentEn');
		$contentEn->setAttrib('COLS', '40')
				 	->setAttrib('class', 'form-control')
				 	->setAttrib('ROWS', '4')
				 	->setDecorators(array('ViewHelper'));
		$metaTitle = new Zend_Form_Element_Textarea('metaTitle');
		$metaTitle->setAttrib('class', 'article-seo')
				 	->setAttrib('id', 'tbMetaTitle')
				 	->setAttrib('COLS', '40')
				 	->setAttrib('class', 'form-control')
				 	->setAttrib('ROWS', '4')
				 	->setDecorators(array('ViewHelper'));
		$metaKeyword = new Zend_Form_Element_Textarea('metaKeyword');
		$metaKeyword->setAttrib('class', 'article-seo')
				 	->setAttrib('id', 'tbMetaKeyword')
				 	->setAttrib('COLS', '40')
				 	->setAttrib('class', 'form-control')
				 	->setAttrib('ROWS', '4')
				 	->setDecorators(array('ViewHelper'));
		$metaDescription = new Zend_Form_Element_Textarea('metaDescription');
		$metaDescription->setAttrib('class', 'article-seo')
				 		->setAttrib('id', 'tbMetaDescripttion')
				 		->setAttrib('COLS', '40')
				 		->setAttrib('class', 'form-control')
				 		->setAttrib('ROWS', '4')
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
		/* $isNew = new Zend_Form_Element_Radio('isNew');
		$isNew->addFilter('StringTrim')
				->setAttrib('class', 'grey')
				->setMultiOptions(array('1' => "Có",'0' => "Không"))
				->setValue('0')
				->setDecorators(array('ViewHelper'));
		$featured = new Zend_Form_Element_Radio('featured');
		$featured->addFilter('StringTrim')
					->setAttrib('class', 'grey')
					->setMultiOptions(array('1' => "Có",'0' => "Không"))
					->setValue('0')
					->setDecorators(array('ViewHelper')); */
		$arrElement = array(
				$titleEn,
				$aliasEn,
				$introEn,
				$contentEn,
				$metaTitle,
				$metaKeyword,
				$metaDescription,
				$status,
				$weight
		);
		if(VIETNAM == 1) {
			$titleVi = new Zend_Form_Element_Text('titleVi');
			$titleVi->addFilter('StringTrim')
					->setAttrib('class', 'form-control')
					->setDecorators(array('ViewHelper'));
			$aliasVi = new Zend_Form_Element_Text('aliasVi');
			$aliasVi->addFilter('StringTrim')
					->setAttrib('class', 'form-control')
					->setDecorators(array('ViewHelper'));
			$introVi = new Zend_Form_Element_Textarea('introVi');
			$introVi->addFilter('StringTrim')
					->setAttrib('COLS', '40')
				 	->setAttrib('class', 'form-control')
				 	->setAttrib('ROWS', '4')
					->setDecorators(array('ViewHelper'));
			$contentVi = new Zend_Form_Element_Textarea('contentVi');
			$contentVi->addFilter('StringTrim')
				->setRequired(true)
				->addValidator('notEmpty')
				->setAttrib('class', 'form-control')
				->setDecorators(array('ViewHelper'));
			$arrElement[]=$titleVi;
			$arrElement[]=$aliasVi;
			$arrElement[]=$introVi;
			$arrElement[]=$contentVi;
		}
		$this->addElements($arrElement);
	}
}