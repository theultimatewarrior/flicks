<?php
	define('API_KEY', 'v5xx2reh7qxsbmv6dc7ayhvd');
	define('API_URL', 'http://api.rottentomatoes.com/api/public/v1.0/movies');
	
	class RTDb {
        
        protected $movie_search;
		
		public function search_movie($query) {
            $query = str_replace(' ', '+', $query);
			$url = '.json?apikey=' . API_KEY . '&q=' . $query;
			
			$this->movie_search = $this->_make_call($url);
            
            $this->_parse_results();
		}
        
        private function _parse_results() {
            
            $MoviesResult = json_decode($this->movie_search, true);
            
            foreach ($MoviesResult['movies'] as $movie) {
                
                // Display movie poster
                echo '<li>
                        <a href="movie.php?id=' . $movie['id'] . '">
                            <img src="' . $movie['posters']['thumbnail'] . '" class="ui-li-thumb" />';
                // Display movie title      
                echo '<span class="ui-li-heading">' . $movie['title'] . ' ';
                            
                // Display movie year
                if ($movie['year'] != null) {
                    echo '(' . $movie['year'] . ')</span>';
                } else {
                    echo '</span>';
                }
                echo '<p class="ui-li-desc">';
                
                // Display movie cast
                $numItems = count($movie['abridged_cast']);
                $i = 0;
                foreach ($movie['abridged_cast'] as $name) {
                    echo $name['name'];
                    if (++$i != $numItems) {
                        echo ', ';
                    }
                }
                
                echo '</p></a></li>';
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