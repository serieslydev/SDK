<?php 
/**
* Series.ly API v2.0 SDK class for PHP
*	
* @author	David Maillo (www.davidmaillo.com)
* @version	1.0
* @link 	http://api.series.ly/docs (API documentation)
**/

	class seriesly_api
	{
		public $auth_token;
		public $user_token;
		public $user_expires_date;

		/*-------------------------------------- 
		 	AUTHENTICATION AND USER LOGIN
		----------------------------------------*/
		//Get the auth_token:
		public function get_auth_token($id, $secret)
		{
			$base_url = 'http://api.series.ly/v2/auth_token';
			$params = array(
			    'id_api' => $id,
			    'secret' => $secret
			);
			$query = $base_url.'?'.http_build_query($params);
			$response = file_get_contents($query);
			$data = json_decode($response, TRUE); // true for recursively to Array

			$this->auth_token = $data['auth_token'];

			if ($data['error'] == 0) return $data["auth_token"];
			else echo __FUNCTION__." error: ".$data['error'];
		}

		//Make login and redirect to a callback file:
		public function user_login($redirect){
			$base_url = 'http://api.series.ly/v2/user/user_login';
			$params = array(
			    'auth_token' => $this->auth_token,
			    'redirect_url' => $redirect
			);
			$query = $base_url . '?' . http_build_query($params);
			header('Location: ' . $query);
		}

		//Get the user token (permissions from user):
		public function get_user_token($method="GET"){
			global $_SESSION, $_GET;

			switch ($method){
				case "SESSION": 
					$this->user_token = $_SESSION['user_token'];
					$this->user_expires_date = $_SESSION['user_expires_date'];
					break;

				case "GET":
					$this->user_token = $_GET['user_token'];
					$this->user_expires_date = $_GET['user_expires_date'];
					break;
			}
		}

		//Logout:
		public function user_logout(){
			$base_url = 'http://api.series.ly/v2/user/logout';
			$params = array(
			    'auth_token' => $this->auth_token,
			    'user_token' => $this->user_token
			);
			$query = $base_url . '?' . http_build_query($params);
			$response = file_get_contents($query);
			$data = json_decode($response, TRUE); // true for recursively to Array
			if ($data['error'] == 0) {
			    // Sucess response, no error found.
			    // Now you can request a new user_token for other user. 
			}
			if ($data['error'] == 0) return $data;
			else echo __FUNCTION__." error: ".$data['error'];
		}

		/*-------------------------------------- 
		 	USER INFO
		----------------------------------------*/
		//Retrieve user information: Name, surname, email, user ID, score, gender...
		public function user(){
			$base_url = 'http://api.series.ly/v2/user';
			$params = array(
			    'auth_token' => $this->auth_token,
			    'user_token' => $this->user_token
			);
			$query = $base_url . '?' . http_build_query($params);
			$response = file_get_contents($query);
			$data = json_decode($response, TRUE); // true for recursively to Array

			return $data;
		}

		/*-------------------------------------- 
		 	USER / MEDIA
		----------------------------------------*/
		//Retrieve all the saved media of the user:
		public function user_media($type="")
		{
			$base_url = 'http://api.series.ly/v2/user/media';
			switch ($type)
			{
				case "series":			$base_url .= "/series"; break;
				case "movies":			$base_url .= "/movies"; break;
				case "tvshows":			$base_url .= "/tvshows"; break;
				case "documentaries":	$base_url .= "/documentaries";
			}
			$params = array(
			    'auth_token' => $this->auth_token,
			    'user_token' => $this->user_token
			);
			$query = $base_url . '?' . http_build_query($params);
			$response = file_get_contents($query);
			$data = json_decode($response, TRUE); // true for recursively to Array
			if ($data['error'] == 0) return $data;
			else echo __FUNCTION__." error: ".$data['error'];
		}

		public function user_media_recommended(){
			$base_url = 'http://api.series.ly/v2/user/media/recommended';
			$params = array(
			    'auth_token' => $this->auth_token,
			    'user_token' => $this->user_token
			);
			$query = $base_url . '?' . http_build_query($params);
			$response = file_get_contents($query);
			$data = json_decode($response, TRUE); // true for recursively to Array
		    if ($data['error'] == 0) return $data;
			else echo __FUNCTION__." error: ".$data['error'];
		}

		/*-------------------------------------- 
		 	MEDIA
		----------------------------------------*/
		/* Perform a new search */
		public function media_search($query="", $onlyTitle="", $page="", $per_page="", $order="", $year="", $decade="", $genere="", $mediaType=""){
			$base_url = 'http://api.series.ly/v2/media/search';

			if ($mediaType == "") unset($mediaType);
			
			$params = array(
			    'auth_token' 		=> $this->auth_token,
			    'q' 				=> $query,
			    'year' 				=> $year,
			    'decade' 			=> $decade,
			    'page' 				=> $page,
			    'per_page' 			=> $per_page,
			    'genere' 			=> $genere,
			    'mediaType'			=> $mediaType,
			    'order' 			=> $order,
			    'onlyTitle' 		=> $onlyTitle
			);
			$query = $base_url . '?' . http_build_query($params);
			$response = file_get_contents($query);
			$data = json_decode($response, TRUE); // true for recursively to Array
		    if ($data['error'] == 0) return $data;
			else echo __FUNCTION__." error: ".$data['error'];
		}

		/* List of most seen media */
		public function media_most_seen($type="", $limit=10){
			$base_url = 'http://api.series.ly/v2/media/most_seen';
			switch ($type)
			{
				case "series":			$base_url .= "/series"; break;
				case "movies":			$base_url .= "/movies"; break;
				case "tvshows":			$base_url .= "/tvshows"; break;
				case "documentaries":	$base_url .= "/documentaries";
			}
			$params = array(
			    'auth_token' => $this->auth_token,
			    'limit' => $limit
			);
			$query = $base_url . '?' . http_build_query($params);
			$response = file_get_contents($query);
			$data = json_decode($response, TRUE); // true for recursively to Array
			if ($data['error'] == 0) return $data;
			else echo __FUNCTION__." error: ".$data['error'];
		}

		/* Full info of media */
		public function media_full_info($mediaType="", $idm="", $multiple=""){
			$base_url = 'http://api.series.ly/v2/media/full_info';
				
				if (empty($multiple)) {
				/* Single media */
					$params = array(
					    'auth_token' => $this->auth_token,
					    'mediaType' => $mediaType, // See mediaType constants reference. 
					    'idm' => $idm
					);
				}
				else {
				/* Multiple media */ 
				$params = array(
				    'auth_token' => $this->auth_token,
				    'group' => $multiple
				    );
				}
			$query = $base_url . '?' . http_build_query($params);
			$query = str_replace("%5B", "[", $query);
			$query = str_replace("%5D", "]", $query);
			$response = file_get_contents($query);
			$data = json_decode($response, TRUE); // true for recursively to Array
			if ($data['error'] == 0) return $data;
			else echo __FUNCTION__." error: ".$data['error'];
		}

		/*-------------------------------------- 
		 	TOOLS
		----------------------------------------*/
		//Know if user is logged in correctly
		public function logged_in(){
			$check = $this->user();
			if ($check["error"] == 0)
				return true;
			else
				return false;
		}
		//Api information
		public function show_quota(){
		    $base_url = 'http://api.series.ly/v2/app/show_quota';
		    $params = array (
		      'auth_token' => $this->auth_token,
		      'user_token' => $this->user_token,
		    );
		    $query = $base_url.'?'.http_build_query($params);
		    $response = file_get_contents($query);
		    $data = json_decode($response, TRUE); // true for recursively to Array
		    if ($data['error'] == 0) return $data;
			else echo __FUNCTION__." error: ".$data['error'];
		}

		//Translate genre of media
		public function translate_genre($genre, $lang="ES")
		{
			//SPANISH
			if ($lang == "ES")
			{
				switch($genre)
				{
					case "Action": $g 		= "Acción"; break;
					case "Comedy": $g 		= "Comedia"; break;
					case "Family": $g 		= "Familiar"; break;
					case "History": $g 		= "Historia"; break;
					case "Mystery": $g 		= "Misterio"; break;
					case "Sci": $g 			= "Ciencia ficción"; break;
					case "War": $g 			= "Guerra"; break;
					case "Adventure": $g 	= "Aventura"; break;
					case "Crime": $g 		= "Crimen"; break;
					case "Fantasy": $g 		= "Fantasía"; break;
					case "Horror": $g 		= "Terror"; break;
					case "News": $g 		= "Actualidad"; break;
					case "Sport": $g 		= "Deportes"; break;
					case "Western": $g 		= "Western"; break;
					case "Animation": $g 	= "Animación"; break;
					case "Documentary": $g 	= "Documental"; break;
					case "Film-noir": $g 	= "Cine negro"; break;
					case "Music": $g 		= "Música"; break;
					case "Drama": $g 		= "Drama"; break;
					case "Musical": $g 		= "Musical"; break;
					case "Romance": $g 		= "Romance"; break;
					case "Thriller": $g 	= "Thriller"; break;
					case "Reallity": $g 	= "Reallity Show"; break;
					case "Biography": $g 	= "Biografía"; break;
					default: $g = "";
				}
			}
		return $g;
		}
	}
?>