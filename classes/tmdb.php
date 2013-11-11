<?php
	define("TMDB_API_KEY", "78ff199f1355b4b050f29c2337c065a6");
	define("TMDB_API_URL", "http://api.themoviedb.org/");
	define("BASE_IMAGE_PATH", "http://d3gtl9l2a4fn1j.cloudfront.net/t/p/w500");
	/*
	search by imdb id:
http://api.themoviedb.org/3/movie/tt1731141?api_key=78ff199f1355b4b050f29c2337c065a6
	*/
	
	class TMDB {
		
		protected $_movie;
		
		public function imdb_lookup($mid) {
		
			// get JSON data
			$url = '3/movie/' . $mid . '?api_key=' . TMDB_API_KEY;

			$results = $this->make_call($url);
			return $results;
			
			/*
			$JSONarray = json_decode($results, true);
			
			foreach($JSONarray['results'] as $result) {
			
			}
			*/
		}
		
		public function get_showtimes() {
			
			$url = '3/movie/top_rated?api_key=' . API_KEY;
			
			echo $this->make_call($url);
		}
		
		public function make_call($url) {
		
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, TMDB_API_URL . $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json"));
			$response = curl_exec($ch);
			curl_close($ch);

			return $response;
		}
	}
	
	$t = new TMDB();
	$t->get_showtimes();
?>