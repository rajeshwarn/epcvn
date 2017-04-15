<?php
	// This script accepts an ID and looks in the user's session for stored thumbnail data.
	// It then streams the data to the browser as an image
	
	// Work around the Flash Player Cookie Bug
	/**
	if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	}
	*/
	
	
	session_start();
	
	$image_id = isset($_GET["id"]) ? $_GET["id"] : false;
	
	if ($image_id === false) {
		header("HTTP/1.1 500 Internal Server Error");
		echo "No ID";
		exit(0);
	}
	
	
	if (!is_array($_SESSION["image"]) || !isset($_SESSION["image"][$image_id])) {
		header("HTTP/1.1 404 Not found");
		exit(0);
	}
	
  $image = $_SERVER['DOCUMENT_ROOT'].'/public/uploads/products/'.$_SESSION["image"][$image_id];
  $info = getimagesize($image);

	header("Content-type: ".$info['mime']) ;
	//header("Content-Length: ".strlen());
  echo file_get_contents($image);
//	echo $_SESSION["file_info"][$image_id];
	exit(0);
?>