<?php
	require_once("api_config.php");
	$api->get_auth_token($id_app, $secret);
	$api->get_user_token();

		/* ...Now you can work with $api to do everything.

			EXAMPLE:
				$media = $api->user_media("movies");
				print_r($media);

		--------------------------------------------------------------------------------

		SEARCH EXAMPLE:

		//Parameters:
			$query = "Jurassic Park"
			$onlyTitle = "";
			$page = "";
			$per_page = 10;
			$order = "rating";
			$year = "";
			$decade = "true";
			$genere = "";
			$mediaType = "";

		//Searching:
		$media = $api->media_search($query, $onlyTitle, $page, $per_page, $order, $year, $decade, $genere, $mediaType);


		---------------------------------------------------------------------------------
		
		CHECK IF IT'S VALID USER:
		
		if (!$api->logged_in()) die("Not logged in");
		*/
?>