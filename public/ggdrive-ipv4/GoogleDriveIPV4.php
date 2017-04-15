<?php 
/**
* Code get link google drive IPv4, IPv6
* Login with account google gsuite: http://gsuite.google.com/
* Create Time: 28/11/2016
* Author: Hai Long
* Author website: http://longit.net
* Blog: https://blogit.vn
* API: https://api.blogit.vn
* Contact: 
* 	- Email: hailong1803@gmail.com
* 	- Skype: hailong1803
* 	- Fb: fb.com/hailong1803
*/
class GoogleDriveIPV4
{
	protected $link;
	protected $file;
	protected $id;
	protected $urlLogin;
	protected $account;
	protected $pass;
	function __construct($acc = '')
	{
		$this->file = '';
		// login google
		$this->urlLogin = 'https://accounts.google.com/signin/challenge/sl/password';
		if($acc == '')
			$this->infoAccount = $this->accountGsuite();
		else
			$this->infoAccount = $this->accountGsuite($acc);
		$this->autoCheckLogin();
	}
	/**
	 * get link drive
	 * @time   2016-11-26T18:39:32+0700
	 * @author HaiLong
	 * @param  integer                  $i
	 * @return array
	 */
	public function get($link, $i = 0){
		$this->link = $link;
		$result = array();
		if( $this->getDriveID() ) {
			$body = $this->curl($this->file);
			$check = $this->readString($body,'status=', '&');
			if($body && $check === 'ok') {
				if (strpos($body, 'ipbits%3D8') || strpos($body, 'ipbits%3D32')) {
			        $this->loginGoogle();
			        $i++;
			        if($i < 3)
			        	$this->get($link, $i);
			        else
			        	return $result;
			    }
			    $fmt_stream_map = $this->readString($body, 'fmt_stream_map=','&');
				$title = $this->readString($body, 'title=','&');
				$urls = explode(',', urldecode($fmt_stream_map));
				$result['title'] = $title;
				$result['link'] = array();
				foreach ($urls as $u) {
					list($itag,$file) = explode('|', $u);
					$infoItag = $this->itagMap($itag);
					$var['label'] = $infoItag['quality'];
					if($var['label'] == 360)
						$var['default'] = 'true';
					else
						$var['default'] = 'false';
					$var['type'] = $infoItag['type'];
					$var['file'] = preg_replace("/(.*)\.googlevideo\.com/", "https://redirector.googlevideo.com", $file);
					$var['file'] = preg_replace("/(.*)\.google\.com/", "https://redirector.googlevideo.com", $var['file']);
					//$var['file'] = preg_replace("/ipbits=(.*)\&/", "ipbits=0&", $var['file']);
					$explodeURL = explode('videoplayback?', $var['file']);
					$var['file'] = $explodeURL[0].'videoplayback?api=api.blogit.vn&'.$explodeURL[1];
					if($var['type'] == 'mp4'){
						array_push($result['link'], $var);
					}
				}
			}
		}
		return $result;
	}
	/**
	 * info account gsuite
	 * @time   2017-01-06T11:56:26+0700
	 * @author HaiLong
	 * @param  string                   $number
	 * @return array                           
	 */
	private function accountGsuite($number = ''){
		// mỗi thông tin tài khoản lưu vào 1 mảng, và 1 file cookie.txt
		$account = array(
			array(
				'id' => 'watch@esrefesen.com',
				'pass' => '123654nn',
				'cookie' => 'cookie_0.txt'
				),
			);
		if($number == ''){
			$randKey = array_rand($account, 1);
			return $account[$randKey];
		}else{
			return $account[$number];
		}
	}
	/**
	 * check login
	 * @time   2016-11-26T18:39:53+0700
	 * @author HaiLong
	 * @param  boolean                  $login
	 * @return string                          
	 */
	public function checkLogin($login = ''){
		if($login != ''){
			$url = 'https://accounts.google.com/signin/challenge/kpe/2';
			$data = '';
			$confirm = $this->curl($url, $data);
			return $confirm;
		}else{
			$checkLogin = $this->loginGoogle();
			return $checkLogin;
		}
	}

	public function autoCheckLogin(){
		$file = 'cookie/'.$this->infoAccount['cookie'];
		$filesize = filesize($file);
		if($filesize < 1000){
			$this->loginGoogle();
			$data = file_get_contents('check.txt');
			$txt = $data."\n".date("Y-m-d H:i:s");
			$fp = fopen('check.txt', "w") or die("Unable to open file!");
			fwrite($fp, $txt);
			fclose($fp);
		}
	}

	/**
	 * login google
	 * @time   2016-11-26T18:40:11+0700
	 * @author HaiLong
	 * @return [type]                   [description]
	 */
	private function loginGoogle(){
		$pageLogin  = $this->curl($this->urlLogin);
	    preg_match('/"Page"(.*)value="(.*)"/U', $pageLogin, $Page);
	    preg_match('/"GALX"(.*)value="(.*)"/U', $pageLogin, $GALX);
	    preg_match('/"gxf"(.*)value="(.*)"/U', $pageLogin, $gxf);
	    preg_match('/"continue"(.*)value="(.*)"/U', $pageLogin, $continue);
	    preg_match('/"service"(.*)value="(.*)"/U', $pageLogin, $service);
	    preg_match('/"hl"(.*)value="(.*)"/U', $pageLogin, $hl);
	    preg_match('/"_utf8"(.*)value="(.*)"/U', $pageLogin, $_utf8);
	    preg_match('/"bgresponse"(.*)value="(.*)"/U', $pageLogin, $bgresponse);
	    preg_match('/"pstMsg"(.*)value="(.*)"/U', $pageLogin, $pstMsg);
	    preg_match('/"dnConn"(.*)value="(.*)"/U', $pageLogin, $dnConn);
	    preg_match('/"checkConnection"(.*)value="(.*)"/U', $pageLogin, $checkConnection);
	    preg_match('/"signIn"(.*)value="(.*)"/U', $pageLogin, $signIn);
	    $dataSubmit = '';
	    if(isset($Page[2]))
	    	$dataSubmit .= 'Page='.$Page[2];
	    if(isset($GALX[2]))
	    	$dataSubmit .= '&GALX='.$GALX[2];
	    if(isset($gxf[2]))
	    	$dataSubmit .= '&gxf='.$gxf[2];
		if(isset($continue[2]))
			$dataSubmit .= '&continue='.$continue[2];
		if(isset($service[2]))
			$dataSubmit .= '&service='.$service[2];
		if(isset($hl[2]))
			$dataSubmit .= '&hl='.$hl[2];
		if(isset($_utf8[2]))
			$dataSubmit .= '&_utf8='.$_utf8[2];
		if(isset($bgresponse[2]))
			$dataSubmit .= '&bgresponse='.$bgresponse[2];
		if(isset($pstMsg[2]))
			$dataSubmit .= '&pstMsg='.$pstMsg[2];
		if(isset($dnConn[2]))
			$dataSubmit .= '&dnConn='.$dnConn[2];
		if(isset($checkConnection[2]))
			$dataSubmit .= '&checkConnection='.$checkConnection[2].'&checkedDomains=youtube&PersistentCookie=yes';
		if(isset($signIn[2]))
			$dataSubmit .= '&signIn='.$signIn[2];
		if($this->infoAccount['id'])
			$dataSubmit .= '&Email='.$this->infoAccount['id'];
		if($this->infoAccount['pass'])
			$dataSubmit .= '&Passwd='.$this->infoAccount['pass'];
	    return $this->curl($this->urlLogin, $dataSubmit);
	}

	/**
	 * get drive ID
	 * @time   2016-11-26T18:40:23+0700
	 * @author HaiLong
	 * @return true/false                  
	 */
	private function getDriveID(){
		preg_match('/(?:https?:\/\/)?(?:[\w\-]+\.)*(?:drive|docs)\.google\.com\/(?:(?:folderview|open|uc)\?(?:[\w\-\%]+=[\w\-\%]*&)*id=|(?:folder|file|document|presentation)\/d\/|spreadsheet\/ccc\?(?:[\w\-\%]+=[\w\-\%]*&)*key=)([\w\-]{28,})/i', $this->link , $match);
		if(isset($match[1])) {
			$this->file = 'https://docs.google.com/get_video_info?docid='.$match[1];
			$this->id = $match[1];
			return true;
		}else{
			return false;
		}
	}

	/**
	 * read string
	 * @time   2016-11-26T18:40:43+0700
	 * @author HaiLong
	 * @param  string                   $string    
	 * @param  string                   $findStart 
	 * @param  string                   $findEnd  
	 * @return string
	 */
	private function readString($string, $findStart, $findEnd){
		$start = stripos($string, $findStart);
		if($start === false) return false;
		$length = strlen($findStart);
		$end = stripos(substr($string, $start+$length), $findEnd);
		if($end !== false) {
			$rs = substr($string, $start+$length, $end);
		} else {
			$rs = substr($string, $start+$length);
		}
		if($rs){
			$rs = trim($rs);
			return $rs;
		}else{
			return false;
		}
	}

	/**
	 * get info itag
	 * @time   2016-11-26T18:41:05+0700
	 * @author HaiLong
	 * @param  int                   $itag
	 * @return                          
	 */
	private function itagMap($itag){
		$itag = (int)$itag;
		switch ($itag) {
			case 17:
				$quality = 360;
				$type = "3gpp";
				break;
			case 36:
				$quality = 480;
				$type = "3gpp";
				break;
			case 5:
				$quality = 240;
				$type = "flv";
				break;
			case 34:
				$quality = 360;
				$type = "flv";
				break;
			case 35:
				$quality = 480;
				$type = "flv";
				break;
			case 18:
				$quality = 360;
				$type = "mp4";
				break;
			case 59:
				$quality = 480;
				$type = "mp4";
				break;
			case 22:
				$quality = 720;
				$type = "mp4";
				break;
			case 37:
				$quality = 1080;//1920 x 1080
				$type = "mp4";
				break;
			case 38:
				$quality = 1080;//2048 x 1080
				$type = "mp4";
				break;
			case 43:
				$quality = 360;
				$type = "webm";
				break;
			case 44:
				$quality = 480;
				$type = "webm";
				break;
			case 45:
				$quality = 720;
				$type = "webm";
				break;
			case 46:
				$quality = 1080;
				$type = "webm";
				break;
			default:
				$quality = 0;
				$type = "";
				break;
		}
		
		return array("quality"=>$quality,"type"=>$type);
	}

	/**
	 * curl
	 * @time   2016-11-26T18:41:25+0700
	 * @author HaiLong
	 * @param  string                   $url
	 * @param  string                   $data
	 * @return string                       
	 */
	public function curl($url, $data = ''){
	    $ch = @curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	    if ($data) {
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    }
	    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie/'.$this->infoAccount['cookie']);
	    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie/'.$this->infoAccount['cookie']);
	    $result = curl_exec($ch);
	    curl_close($ch);
	    return $result;
	}
}
?>