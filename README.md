# SERIESLY API PHP SDK #
## USAGE EXAMPLE: ##

* api_config.php

<code>
require_once("seriesly.class.php");
$api = new seriesly_api();
$id_app = "XXX";
$secret = "XXXXXXXXXXXXX";
$callback_url = "http://mydomain.com/mypage.php"; // Page to redirect after login (Where the application starts)
</code>

* login.php
<code>
	require_once("api_config.php");         
	$api->get_auth_token($id_app, $secret);         
	$api->user_login($callback_url);      
</code> 

* mypage.php
<code>
	require_once("api_config.php");
	$api->get_auth_token($id_app, $secret);
	$api->get_user_token();
</code>
