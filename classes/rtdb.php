<?php
	define('API_KEY', 'v5xx2reh7qxsbmv6dc7ayhvd');
	define('API_URL', 'http://api.rottentomatoes.com/api/public/v1.0/movies');
	require_once("includes/Mobile_Detect.php");
	require_once("tmdb.php");
	
	class RTDb {
        
        protected $movie_search;
		protected $movie;
		protected $imdb_id;
		protected $tmdb_movie;
		
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
			
			$this->tmdb_movie = new TMDB();
			$this->tmdb_movie = $this->tmdb_movie->imdb_lookup($this->imdb_id);

			//echo (string)$this->tmdb_movie;
		}
		
		private function _parse_movie() {
			$detect = new Mobile_Detect();
			$json_movie = json_decode($this->movie, true);
			$date = new DateTime($json_movie['release_dates']['theater']);
			$this->imdb_id = 'tt' . $json_movie['alternate_ids']['imdb'];
			$num_genres = count($json_movie['genres']);
			$i = 0;
			
			echo '<div class="movie_head">
					  <div class="movie_poster">
						<img class="poster" src="' . $json_movie['posters']['original'] . '" width="100%" />
					  </div>
					  
					  <div class="movie_title">
						<h2 class="title">' . $json_movie['title'] . '<span class="movie_year"> (' . $json_movie['year'] . ')</h2>
						<p class="ui-li-desc" style="white-space: normal">' . $json_movie['mpaa_rating'] . ' | ' . $json_movie['runtime'] . ' min - ';
						foreach ($json_movie['genres'] as $genre) {
							echo $genre;
							if (++$i != $num_genres) {
								echo ' | ';
							}
						};
						echo ' - ' . $date->format('F d Y') . '</p>
					  </div>';
			// For Mobile Devices only
			if( $detect->isMobile() && !$detect->isTablet() ){
				echo '</div>';
				  
				echo '
				<div data-role="collapsible-set" data-inset="false" class="movie_details" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d">
					<div data-role="collapsible">
						<h3>Details</h3>
						<div class="ui-grid-a">
						<div class="ui-block-a">';
						if (count($json_movie['abridged_directors']) > 1) {
							echo '<b>Directors</b>';
						} else {
							echo '<b>Director</b>';
						}
						echo '</div>
						<div class="ui-block-b">';
						foreach ($json_movie['abridged_directors'] as $directors) {
							echo $directors['name'], '<br />';
						}
						echo '</div>
						</div>
						<div class="ui-grid-a">
						<div class="ui-block-a">
							<b>Studio</b>
						</div>
						<div class="ui-block-b">';
						if (empty($json_movie['studio'])) {
							echo 'N/A';
						} else {
							echo $json_movie['studio'];
						}
						echo '</div>
						</div>
					</div>
					<div data-role="collapsible">
						<h3>Synopsis</h3>
						<p>';
						if (empty($json_movie['synopsis'])) {
							echo 'No synopsis found.';
						} else {
							echo $json_movie['synopsis'];
						}
					echo '</p>
					</div>
					
					<div data-role="collapsible">
						<h3>Cast</h3>
						<div class="ui-grid-a">';
							foreach ($json_movie['abridged_cast'] as $cast) {
								echo '<div class="ui-block-a">';
								if (!empty($cast['name'])) {
									echo '<b>' . $cast['name'] . '</b>';
								}
								echo '</div>';
								echo '<div class="ui-block-b">';
								$j = 0;
								if (!empty($cast['characters'])) {
									$num_characters = count($cast['characters']);
									foreach ($cast['characters'] as $character) {
										echo $character;
										if (++$j != $num_characters) {
											echo ' / ';
										}
									}
								}
								echo '</div>';
							}
					echo '</div>
					</div>
				</div>';
			} else {
								echo '
				<div>
					<div>
						<h3>Details</h3>
						<div class="ui-grid-a">
						<div class="ui-block-a">';
						if (count($json_movie['abridged_directors']) > 1) {
							echo '<b>Directors</b>';
						} else {
							echo '<b>Director</b>';
						}
						echo '</div>
						<div class="ui-block-b">';
						foreach ($json_movie['abridged_directors'] as $directors) {
							echo $directors['name'], '<br />';
						}
						echo '</div>
						</div>
						<div class="ui-grid-a">
						<div class="ui-block-a">
							<b>Studio</b>
						</div>
						<div class="ui-block-b">';
						if (empty($json_movie['studio'])) {
							echo 'N/A';
						} else {
							echo $json_movie['studio'];
						}
						echo '</div>
						</div>
					</div>
					<div>
						<h3>Synopsis</h3>
						<p>';
						if (empty($json_movie['synopsis'])) {
							echo 'No synopsis found.';
						} else {
							echo $json_movie['synopsis'];
						}
					echo '</p>
					</div>
					
					<div>
						<h3>Cast</h3>
						<div class="ui-grid-a">';
							foreach ($json_movie['abridged_cast'] as $cast) {
								echo '<div class="ui-block-a">';
								if (!empty($cast['name'])) {
									echo '<b>' . $cast['name'] . '</b>';
								}
								echo '</div>';
								echo '<div class="ui-block-b">';
								$j = 0;
								if (!empty($cast['characters'])) {
									$num_characters = count($cast['characters']);
									foreach ($cast['characters'] as $character) {
										echo $character;
										if (++$j != $num_characters) {
											echo ' / ';
										}
									}
								}
								echo '</div>';
							}
					echo '</div>
					</div>
				</div>';
				// End of .movie_head
				echo '</div>';
			}
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