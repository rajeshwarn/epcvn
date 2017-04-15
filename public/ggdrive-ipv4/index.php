<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include_once('GoogleDriveIPV4.php');
if(isset($_GET['link']) && $_GET['link']){
	$link = $_GET['link'];
	$googleDrive = new GoogleDriveIPV4(); //echo $googleDrive->checkLogin(1);exit();
	$data = $googleDrive->get($link);
	echo json_encode($data);
}
?>