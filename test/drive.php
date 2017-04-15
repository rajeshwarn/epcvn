<?php

error_reporting(0);

function Cookie_google($url,$data){
	$ch = @curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);	
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
	if($data){ 
	curl_setopt($ch, CURLOPT_POST, 1); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	
	}
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie1.txt'); // lưu cookie 
	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie1.txt'); // lấy cookie 
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

function Cooki_google($url,$data){  

$user = 'hoathinha1@dotadrive.com'; // your ID google app https://gsuite.google.com/

$pass = '123654Zz'; // your PASS google app https://gsuite.google.com/



$url = 'https://accounts.google.com/signin/challenge/sl/password';   
$api = Cookie_google('https://accounts.google.com/ServiceLogin','');

preg_match('/"Page"(.*)value="(.*)"/U', $api, $Page);
preg_match('/"GALX"(.*)value="(.*)"/U', $api, $GALX);
preg_match('/"gxf"(.*)value="(.*)"/U', $api, $gxf);
preg_match('/"continue"(.*)value="(.*)"/U', $api, $continue);
preg_match('/"service"(.*)value="(.*)"/U', $api, $service);
preg_match('/"hl"(.*)value="(.*)"/U', $api, $hl);
preg_match('/"_utf8"(.*)value="(.*)"/U', $api, $_utf8);
preg_match('/"bgresponse"(.*)value="(.*)"/U', $api, $bgresponse);
preg_match('/"pstMsg"(.*)value="(.*)"/U', $api, $pstMsg);
preg_match('/"dnConn"(.*)value="(.*)"/U', $api, $dnConn);
preg_match('/"checkConnection"(.*)value="(.*)"/U', $api, $checkConnection);
preg_match('/"signIn"(.*)value="(.*)"/U', $api, $signIn);
$data = 'Page='.$Page[2].'&GALX='.$GALX[2].'&gxf='.$gxf[2].'&continue='.$continue[2].'&service='.$service[2].'&hl='.$hl[2].'&_utf8='.$_utf8[2].'&bgresponse='.$bgresponse[2].'&pstMsg='.$pstMsg[2].'&dnConn='.$dnConn[2].'&checkConnection='.$checkConnection[2].'&checkedDomains=youtube&PersistentCookie=yes&signIn='.$signIn[2].'&Email='.$user.'&Passwd='.$pass;

$login = Cookie_google($url,$data);
echo $login;
}




function drive_google_com($url) {
$id1 = explode('open?id=',$url);
if(empty($id1[1])){
preg_match('/d\/(.*)\//U', $url, $id1);
}if(empty($id1[1])){
$id1[1] = $url;
}
        $get = Cookie_google('https://docs.google.com/get_video_info?docid='.$id1[1]);
if(strpos($get , 'ipbits%3D8') || strpos($get , 'ipbits%3D32')){
        Cooki_google();
        $get = Cookie_google('https://docs.google.com/get_video_info?docid='.$id1[1]);
}
        $url_encoded_fmt_stream_map = $itag = $url = '';
        parse_str($get);
        $data = explode(',',$url_encoded_fmt_stream_map);
                $sources = array();
        foreach($data as $i => $format) {
            parse_str($format);
            $linkMp4    = preg_replace("/\/[^\/]+\.googlevideo\.com/","/redirector.googlevideo.com", urldecode($url)).'&title=dinhnguyen';
            if($itag == '18')
            $sources[]  = array('file' => $linkMp4, 'type' => 'mp4', 'label' => '360p');
            if($itag == '59')
            $sources[]  = array('file' => $linkMp4, 'type' => 'mp4', 'label' => '480p');
            if($itag == '22')
            $sources[]  = array('file' => $linkMp4, 'type' => 'mp4', 'label' => '720p');
            if($itag == '37')
            $sources[]  = array('file' => $linkMp4, 'type' => 'mp4', 'label' => '1080p');
        }
        if($sources)
        return json_encode($sources);
    }
$url = ($_GET['url']);
if($url)
echo drive_google_com($url);

?>
