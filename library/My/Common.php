<?php

class My_Common {

    public static function standardURL($value, $options = null) {
        $result = self::_removeVietnam($value);
        $result = preg_replace('/[^a-zA-Z0-9- ]/', '', $result);
        $result = str_replace(' ', '-', $result);

        return $result;
    }

    public static function dump($expression){
    	echo '<pre>';
    	var_dump($expression);
    	echo '</pre>';    	
    }
    
    public static function sendMail($subject, $bodyText, $bodyHtml, $from, $to){
    	$configs = Zend_Registry::get('config');
    	
    	$config = array("auth" => "login",
    			"username" => $configs['smtpUser'],
    			"password" => $configs['smtpPass'],
    			"port" => 465,
    			"ssl" => "ssl");
    	
    	$tr = new Zend_Mail_Transport_Smtp($configs['smtpHost'], $config);
    	Zend_Mail::setDefaultTransport($tr);
    	$mail = new Zend_Mail("UTF-8");
    	$mail -> setFrom($from);
    	$mail -> addTo($to);
    	$mail -> setSubject($subject);
    	
    	if($bodyText != ''){
    		$mail -> setBodyText($bodyText);
    	}
    	
    	if($bodyHtml != ''){
    		$mail -> setBodyHtml($bodyHtml);
    	}
    	
    	$mail -> send($tr);    	
    }
    
    private static function _removeVietnam($string) {
        $stringOld = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă",
            "ằ", "ắ", "ặ", "ẳ", "ẵ",
            "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ",
            "ì", "í", "ị", "ỉ", "ĩ",
            "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ"
            , "ờ", "ớ", "ợ", "ở", "ỡ",
            "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
            "ỳ", "ý", "ỵ", "ỷ", "ỹ",
            "đ",
            "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă"
            , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
            "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
            "Ì", "Í", "Ị", "Ỉ", "Ĩ",
            "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ"
            , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
            "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
            "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
            "Đ", "ê", "ù", "à");

        $stringNew = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"
            , "a", "a", "a", "a", "a", "a",
            "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
            "i", "i", "i", "i", "i",
            "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o"
            , "o", "o", "o", "o", "o",
            "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
            "y", "y", "y", "y", "y",
            "d",
            "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A"
            , "A", "A", "A", "A", "A",
            "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
            "I", "I", "I", "I", "I",
            "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O"
            , "O", "O", "O", "O", "O",
            "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
            "Y", "Y", "Y", "Y", "Y",
            "D", "e", "u", "a");

        return str_replace($stringOld, $stringNew, $string);
    }
    
    public function getCodeYoutube($value){
    	$pos =	strpos($value,'=');
    	$valueFiltered	= substr($value, $pos+1);
    
    	return $valueFiltered;
    }

}