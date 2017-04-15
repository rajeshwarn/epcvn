<?php

class Admin_Form_Login extends Zend_Form {

  public function init() {
    $userName = new Zend_Form_Element_Text('userName');
    $userName->setRequired(true)
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->setAttrib('class', 'form-control')
            ->setAttrib('placeholder', 'Nhập tên đăng nhập ...')
            ->setDecorators(array('ViewHelper'));


    $password = new Zend_Form_Element_Password('password');
    $password->setRequired(true)
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->setAttrib('placeholder', 'Nhập mật khẩu ...')
            ->setAttrib('class', 'form-control password')
            ->setDecorators(array('ViewHelper'));

    $this->addElements(array(
        $userName,
        $password,
    ));
  }

}
