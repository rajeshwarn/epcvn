<?php

class Admin_Form_Validators_CategoryValid {

    public $messages;

    public function __construct($data) {
        $val = new Zend_Validate_NotEmpty;

        if ($val->isValid($data["titleEn"]) == false) {
            $this->messages[] = "Title is not empty";
        }

        if ($val->isValid($data["aliasEn"]) == false) {
            $this->messages[] = "Alias is not empty";
        }
    }

    public function isValid() {
        if ($this->messages != "") {
            return false;
        } else {
            return true;
        }
    }

}