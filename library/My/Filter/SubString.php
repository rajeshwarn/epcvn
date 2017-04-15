<?php
class My_Filter_SubString implements Zend_Filter_Interface{
	
	public function filter($string, $lenght = 500){
		$filter = new Zend_Filter_StripTags();
		$pStr = trim($filter->filter($string));
		$returnStr = $this->cutstr($pStr, $lenght, '...');
		
		return $returnStr;
	}
	
	public function cutstr($string, $length, $dot = '', $encoding = 'utf8')
	{
		if (strlen($string) <= $length) {
			return $string;
		}
	
		$strcut = '';
		if (strtolower($encoding) == 'utf8') {
			$n = $tn = $noc = 0;
			while ($n < strlen($string)) {
				$t = ord($string[$n]);
				if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
					$tn = 1; $n++; $noc++;
				} elseif(194 <= $t && $t <= 223) {
					$tn = 2; $n += 2; $noc += 2;
				} elseif(224 <= $t && $t < 239) {
					$tn = 3; $n += 3; $noc += 2;
				} elseif(240 <= $t && $t <= 247) {
					$tn = 4; $n += 4; $noc += 2;
				} elseif(248 <= $t && $t <= 251) {
					$tn = 5; $n += 5; $noc += 2;
				} elseif($t == 252 || $t == 253) {
					$tn = 6; $n += 6; $noc += 2;
				} else {
					$n++;
				}
				if ($noc >= $length) {
					break;
				}
			}
			if ($noc > $length) {
				$n -= $tn;
			}
			$strcut = substr($string, 0, $n);
		} else {
			for($i = 0; $i < $length - strlen($dot) - 1; $i++) {
				if (ord($string[$i]) > 127) {
					$strcut .= $string[$i] . $string[++$i];
				} else {
					$strcut .= $string[$i];
				}
			}
		}
	
		return $strcut . $dot;
	}
}