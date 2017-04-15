<?php

class Admin_Form_Category extends Zend_Form {

    public function __construct($options = null) {
        parent::__construct($options);

        $level = new Zend_Form_Element_Hidden('level');
        $level->setValue('1')
                ->setDecorators(array('ViewHelper'));

        $titleVi = new Zend_Form_Element_Text('titleVi');
        $titleVi->addFilter('StringTrim')
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->setAttrib('class', 'form-control')
                ->setAttrib ( 'placeholder', 'Nhập tên danh mục...' )
                ->setDecorators(array('ViewHelper'));
        $titleVi->getValidator('NotEmpty')
        ->setMessage('Chưa nhập tên danh mục.', Zend_Validate_NotEmpty::INVALID);

        $aliasVi = new Zend_Form_Element_Text('aliasVi');
        $aliasVi->addFilter('StringTrim')
                ->setRequired(true)
                ->setAttrib('class', 'form-control')
                ->setDecorators(array('ViewHelper'));
        /**
         * 
          $categoryModel = new Admin_Model_Category();
          $category =  $categoryModel->getFetchPairs();
          $category[''] = PLEASE_SELECT;
          ksort($category);

          $parentId = new Zend_Form_Element_Select('parentId');
          $parentId->addFilter('StringTrim')
          ->setMultiOptions($category)
          ->setAttrib('style', 'width:95%;')
          ->setRequired(true)
          ->setDecorators(array('ViewHelper'));
         */
        $weight = new Zend_Form_Element_Text('weight');
        $weight->addFilter('StringTrim')
                ->addFilter('Int')
                ->addValidator('NotEmpty')
                ->setAttrib('class', 'form-control')
                ->setAttrib ( 'placeholder', 'Nhập thứ tự hiển thị...' )
                ->setValue('999')
                ->setDecorators(array('ViewHelper'));

        $status = new Zend_Form_Element_Radio ( 'status' );
		$status->addFilter('StringTrim')	
				->setAttrib ( 'class', 'grey' )
				->setMultiOptions(array('1' => " Có", '0' => ' Không'))
				->setValue('1')		
				->setDecorators ( array (
						'ViewHelper'
				) );

        $metaTitle = new Zend_Form_Element_Textarea('metaTitle');
        $metaTitle->setAttrib('class', 'product-seo')
                ->setAttrib('id', 'tbMetaTitle')
                ->setAttrib('class', 'form-control limited')
                ->setAttrib('COLS', '40')
                ->setAttrib('ROWS', '4')
                ->setDecorators(array('ViewHelper'));

        $metaKeyword = new Zend_Form_Element_Textarea('metaKeyword');
        $metaKeyword->setAttrib('class', 'product-seo')
                ->setAttrib('id', 'tbMetaKeywords')
                ->setAttrib('class', 'form-control limited')
                ->setAttrib('COLS', '40')
                ->setAttrib('ROWS', '4')
                ->setDecorators(array('ViewHelper'));

        $metaDescription = new Zend_Form_Element_Textarea('metaDescription');
        $metaDescription->setAttrib('class', 'product-seo')
                ->setAttrib('id', 'tbMetaDescription')
                ->setAttrib('class', 'form-control limited')
                ->setAttrib('COLS', '40')
                ->setAttrib('ROWS', '4')
                ->setDecorators(array('ViewHelper'));

        $arrElement = array(
            $titleVi,
            $aliasVi,
            $weight,
            $status,
            $level,
            $metaTitle,
            $metaKeyword,
            $metaDescription
        );

        if (ENGLISH == 1) {
            $titleEn = new Zend_Form_Element_Text('titleEn');
            $titleEn->addFilter('StringTrim')
                    ->setAttrib('class', 'form-control')
                    ->setAttrib ( 'placeholder', 'Nhập tên danh mục (Tiếng anh)...' )                    
                    ->setDecorators(array('ViewHelper'));

            $aliasEn = new Zend_Form_Element_Text('aliasEn');
            $aliasEn->addFilter('StringTrim')
                    ->setAttrib('class', 'form-control')
                    ->setDecorators(array('ViewHelper'));

            $arrElement[] = $titleEn;
            $arrElement[] = $aliasEn;
        }

        $this->addElements($arrElement);
    }

}
