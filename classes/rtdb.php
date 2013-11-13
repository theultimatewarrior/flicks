<?php
	define('API_KEY', 'v5xx2reh7qxsbmv6dc7ayhvd');
	define('API_URL', 'http://api.rottentomatoes.com/api/public/v1.0/movies');
	require_once("mobile_detect.php");
	require_once("tmdb.php");
	
	class RTDb {
        
        protected $movie_search;
		protected $movie;
		protected $imdb_id;
		protected $rtdb_movie;
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
		}
		
		private function _parse_movie() {
			$detect = new Mobile_Detect();
			$json_movie = json_decode($this->movie, true);
			$date = new DateTime($json_movie['release_dates']['theater']);
			
			$this->rtdb_movie = $json_movie;
			$this->imdb_id = 'tt' . $json_movie['alternate_ids']['imdb'];

			$tmdb_movie = new TMDB();
			$tmdb_movie = $tmdb_movie->imdb_lookup($this->imdb_id);
			$this->tmdb_movie = json_decode($tmdb_movie, true);
			
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
				$this->_parse_mobile_movie($json_movie);
			} else {
				$this->_parse_desktop_movie($json_movie);
				// End of .movie_head
				echo '</div>';
			}
		}
		
		private function _parse_desktop_movie($json_movie) {
			$tmdb_movie = $this->tmdb_movie;
			
			echo '
				<div>
					<div>';
					$this->_parse_movie_details();
			
			echo '
					</div>
					
					<div>';
					
					$this->_parse_synopsis();
			echo '</div>
				<div>';
					$this->_parse_cast();
			echo '</div>
				</div>';
		}
		
		private function _parse_mobile_movie($json_movie) {
			$tmdb_movie = $this->tmdb_movie;

			echo '
				<div data-role="collapsible-set" data-inset="false" class="movie_details" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d">
					<div data-role="collapsible">';
						$this->_parse_movie_details();
						
			echo '
					</div>
					<div data-role="collapsible">';
						$this->_parse_synopsis();
			echo '	</div>
					
					<div data-role="collapsible">';
						$this->_parse_cast();
				echo '</div>
				</div>';
		}
		
		private function _parse_directors() {
			$json_movie = $this->rtdb_movie;
			
			echo '<div class="ui-grid-a">
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
			</div>';
		}
		
		private function _parse_production_companies() {
			$tmdb_movie = $this->tmdb_movie;
			// Production Companies
			echo '<div class="ui-grid-a">
				<div class="ui-block-a">';
					$num_companies = count($tmdb_movie['production_companies']);
							
					if ($num_companies > 1) {
						echo '<b>Production Companies</b>';
					} else {
						echo '<b>Production Company</b>';
					}
				echo '</div>
				<div class="ui-block-b">';
					if (empty($tmdb_movie['production_companies'])) {
						echo 'N/A';
					} else {
						$i = 0;
						foreach ($tmdb_movie['production_companies'] as $studio) {
							echo $studio['name'];
							if (++$i != $num_companies) {
								echo '<br />';
							}
						}
					}
				echo '</div>
			</div>';
		}
		
		private function _parse_production_countries() {
		
			$tmdb_movie = $this->tmdb_movie;
			$num_countries = count($tmdb_movie['production_countries']);
			echo '<div class="ui-grid-a">
				<div class="ui-block-a">';
					if ($num_countries > 1) {
						echo '<b>Production Countries</b>';
					} else {
						echo '<b>Production Country</b>';
					}
				echo '</div>
							
				<div class="ui-block-b">';
					$i = 0;
					if (empty($tmdb_movie['production_countries'])) {
						echo 'N/A';
					} else {
						foreach ($tmdb_movie['production_countries'] as $country) {
							echo $country['name'];
							if (++$i != $num_countries) {
								echo '<br />';
							}
						}
					}
				echo '</div>
			</div>';
		}
		
		private function _parse_budget() {
			$tmdb_movie = $this->tmdb_movie;
			
			echo '<div class="ui-grid-a">
				<div class="ui-block-a">
					<b>Budget</b>
				</div>
							
				<div class="ui-block-b">';
					if ($tmdb_movie['budget'] == 0 || empty($tmdb_movie['budget']))
						echo 'N/A';
					else
						echo '$' . number_format($tmdb_movie['budget'], 0);
			echo '</div>
			</div>';
		}
		
		private function _parse_revenue() {
			$tmdb_movie = $this->tmdb_movie;
			
			echo '<div class="ui-grid-a">
				<div class="ui-block-a">
					<b>Revenue</b>
				</div>
							
				<div class="ui-block-b">';
					if ($tmdb_movie['revenue'] == 0 || empty($tmdb_movie['revenue']))
						echo 'N/A';
					else
						echo '$' . number_format($tmdb_movie['revenue'], 0);
			echo '</div>
			</div>';		
		}
		
		private function _parse_movie_details() {
			echo '<h3 class="subtitle">Details</h3>';
						
			// Directors
			$this->_parse_directors();
			
			// Production Companies
			$this->_parse_production_companies();
			
			// Production Countries
			$this->_parse_production_countries();
			
			// Budget
			$this->_parse_budget();
			
			// Revenue
			$this->_parse_revenue();
		}
		
		private function _parse_synopsis() {
			$tmdb_movie = $this->tmdb_movie;
			$json_movie = $this->rtdb_movie;
			
			echo '
				<h3 class="subtitle">Synopsis</h3>
				<p>';
					if (empty($json_movie['synopsis'])) {
						echo $tmdb_movie['overview'];
					} else {
						echo $json_movie['synopsis'];
					}
				echo '</p>';
		}
		
		private function _parse_cast() {
			$tmdb = new TMDB();
			$credits = $tmdb->get_credits($this->imdb_id);
			$cast_members = json_decode($credits, true);
            $detect = new Mobile_Detect();
			$count = count($cast_members['cast']);
            
            echo '<h3 class="subtitle">Cast</h3>';
			if (!$detect->isMobile()) {
                echo '<div class="ui-grid-b">';
				foreach ($cast_members['cast'] as $cast) {
                    
                    if ($count % 3 == 0) {
                        echo '<div class="ui-block-a">';
                    } else if ($count % 3 == 1){
                        echo '<div class="ui-block-b">';
                    } else {
                        echo '<div class="ui-block-c">';
                    }
                    $count -= 1;
                    echo '<div class="ui-grid-a">';
                    
                    echo '<div class="ui-block-a" style="margin-bottom: 10px; width: 15%;">';
                    if (!empty($cast['profile_path'])) {
						echo '<img style="width: 80%;" src="http://d3gtl9l2a4fn1j.cloudfront.net/t/p/w185/' . $cast['profile_path'] . '" />';
					} else {
						echo '<img style="width: 80%;" src="images/no_avatar.jpg" />';
					}
							
					echo '</div>';
							
					echo '<div class="ui-block-b" style="margin-bottom: 10px; width: 85%;">';
					if (!empty($cast['name'])) {
						echo '<b>' . $cast['name'] . '</b>';
						if (!empty($cast['character'])) {
							echo '<br />' . $cast['character'];
						} else {
							echo 'N/A';
						}
						echo '</div>';
					} else {
						echo 'N/A';
					}
                    echo '</div>';
                    echo '</div>';
				}
                echo '</div>';
            } else {
                echo '<ul data-role="listview" data-inset="false" data-split-icon="plus" data-split-theme="a">';
                foreach ($cast_members['cast'] as $cast) {
                    echo '<li><a href="">';
                    if (!empty($cast['profile_path'])) {
						echo '<img style="height: 100%; width:63px" src="http://d3gtl9l2a4fn1j.cloudfront.net/t/p/w185/' . $cast['profile_path'] . '" />';
					} else {
						echo '<img src="images/no_avatar.jpg" />';
					}
                    echo '<div style="margin: 0 -2em; padding-right: 2em;">';
                    if (!empty($cast['name'])) {
                        echo '<b>' . $cast['name'] . '</b>';
                        if (!empty($cast['character'])) {
                            echo '<p class="ui-li-desc">' . $cast['character'] . ' </p>';
                        } else {
                            echo 'N/A';
                        }
                    } else {
                        echo 'N/A';
                    }
                    echo '</div></a></li>';
                }
                echo '</ul>';
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