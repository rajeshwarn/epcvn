<?php
class My_Filter_GetCodeYoutube implements Zend_Filter_Interface{
	
	public function __construct($link){
	}
	
	public function filter($value){
		$pos =	strpos($value,'=');					
		$valueFiltered	= substr($chuoi, $pos+1);	
		
		return $valueFiltered;
	}
}