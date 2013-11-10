<?php
	define('API_KEY', 'v5xx2reh7qxsbmv6dc7ayhvd');
	define('API_URL', 'http://api.rottentomatoes.com/api/public/v1.0/movies');
	
	class RTDb {
        
        protected $movie_search;
		protected $movie;
		
		public function search_movie($query) {
            $query = str_replace(' ', '+', $query);
			$url = '.json?apikey=' . API_KEY . '&q=' . $query;
			
			$this->movie_search = $this->_make_call($url);
            
            $this->_parse_search_results();
		}
		
		public function get_movie($id) {
			$url = '/' . $id . '.json?apikey=' . API_KEY;
			
			$this->movie = $this->_make_call($url);
			
			$this->_parse_movie();
			
			echo $this->movie;
		}
		
		private function _parse_movie() {
			
			$json_movie = json_decode($this->movie, true);
			
			echo '<div class="container_12">
						<li class="grid_2">
							<img src="' . $json_movie['posters']['detailed'] . '" />
						</li>
						
						<li class="grid_10">
							<h1>' . $json_movie['title'] . '<span class="movie_year"> (' . $json_movie['year'] . ')</h1>
						</li>
					</div>';
		}
        
        private function _parse_search_results() {
            
            $MoviesResult = json_decode($this->movie_search, true);
            
            foreach ($MoviesResult['movies'] as $movie) {
                
                // Display movie poster
				// if img url == http://images.rottentomatoescdn.com/images/redesign/poster_default.gif
                echo '<li>
                        <a href="movie.php?id=' . $movie['id'] . '">
                            <img src="' . $movie['posters']['thumbnail'] . '" class="ui-li-thumb" />';
				echo '<div style="margin: 0 -2em; padding-right: 2em;">';
                // Display movie title      
                echo '<span class="ui-li-heading" style="white-space: normal;">' . $movie['title'] . ' ';
                            
                // Display movie year
                if ($movie['year'] != null) {
                    echo '(' . $movie['year'] . ')</span>';
                } else {
                    echo '</span>';
                }
                echo '<p class="ui-li-desc" style="white-space: normal;">';
                
                // Display movie cast
                $numItems = count($movie['abridged_cast']);
                $i = 0;
                foreach ($movie['abridged_cast'] as $name) {
                    echo $name['name'];
                    if (++$i != $numItems) {
                        echo ', ';
                    }
                }
                
                echo '</p></div></a>';
				// if movie not in database display this
				echo '<a id="add_movie" href="#">Add Movie</a>';
				// else display a different icon with a link to the movie
				echo '</li>';
            }
            
        }
		
		private function _make_call($url) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, API_URL . $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json"));
			$response = curl_exec($ch);
			curl_close($ch);

			return $response;
		}
	}
?>