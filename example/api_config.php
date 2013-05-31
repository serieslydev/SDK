<?php
	// Run the Series.ly class
	require_once("../seriesly.class.php");
	$api = new seriesly_api();

	// Your APP parameters
	$id_app = "XXX";
	$secret = "XXXXXXXXXXXXX";
	$callback_url = "http://mydomain.com/mypage.php"; // Page to redirect after login (Where the application starts)
?>