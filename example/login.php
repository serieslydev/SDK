<?php
	require_once("api_config.php");
	$api->get_auth_token($id_app, $secret);
	$api->user_login($callback_url);
?>