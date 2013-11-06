<?php
	Class Users {
		
		private $_db;
		
		public function __construct($database) {
			$this->_db = $database;
		}
		
		public function user_exists($username) {
			
			$query = $this->_db->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE UPPER(`user_name`) = UPPER(?)");
			$query->bindValue(1, $username);
			
			try {
				
				$query->execute();
				$rows = $query->fetchColumn();
				
				if ($rows >= 1) {
					return true;
				} else {
					return false;
				}
				
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
		
		public function email_exists($email) {
			
			$query = $this->_db->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE UPPER(`email`) = UPPER(?)");
			$query->bindValue(1, $email);
			
			try{
				
				$query->execute();
				$rows = $query->fetchColumn();
				
				if ($rows >= 1){
					return true;
				}else{
					return false;
				}
			
			} catch (PDOException $e){
				die($e->getMessage());
			}
		}
		
		public function register($username, $password, $email) {
			$time			= time();
			$ip				= $_SERVER['REMOTE_ADDR'];
			$email_code		= sha1($username + microtime());
			$password		= sha1($password);
			
			$query = $this->_db->prepare("INSERT INTO `users` (`user_name`, `password`, `email`, `email_code`, `time`, `ip`) VALUES (?, ?, ?, ?, ?, ?) ");
			
			$query->bindValue(1, $username);
			$query->bindValue(2, $password);
			$query->bindValue(3, $email);
			$query->bindValue(4, $email_code);
			$query->bindValue(5, $time);
			$query->bindValue(6, $ip);
			
			try {
				$query->execute();
			
			// mail($email, 'Please activate your account', "Hello " . $username. ",\r\nThank you for registering with us. Please visit the link below so we can activate your account:\r\n\r\nhttp://www.example.com/activate.php?email=" . $email . "&email_code=" . $email_code . "\r\n\r\n-- Example team");
			} catch(PDOException $e){
				die($e->getMessage());
			}
			
			$query_2 = $this->_db->prepare("INSERT INTO `users_extra` (`registered`) VALUES (?)");
			$query_2->bindValue(1, '1');
			
			try {
				$query_2->execute();
			} catch(PDOException $ex) {
				die($ex->getMessage());
			}
		}
		
		public function activate($email, $email_code) {
		
		}
		
		public function email_confirmed($login) {
		
		}
		
		public function login($login, $password) {
			
			$query = $this->_db->prepare("SELECT `password`, `user_id` FROM `users` WHERE UPPER(`user_name`) = UPPER(?)");
			$query->bindValue(1, $login);
			
			try {
				
				$query->execute();
				$data				= $query->fetch();
				$stored_password	= $data['password'];
				$user_id			= $data['user_id'];
				
				if ($stored_password == sha1($password)) {
					return $user_id;
				} else {
					return false;
				}
			} catch(PDOException $e) {
				die($e->getMessage());
			}
		}
		
		public function userdata($user_id) {
			
			$query = $this->_db->prepare("SELECT * FROM `users` WHERE `user_id` = ?");
			$query->bindValue(1, $user_id);
			
			try {
				
				$query->execute();
				
				return $query->fetch();
			} catch(PDOException $e) {
				
				die($e->getMessage());
			}
		}
		
		public function get_users() {
			// Preparing a statement that will select all the registered users, with the most recent
			$query = $this->_db->prepare("SELECT * FROM `users` ORDER BY `time` DESC");
			
			try {
				$query->execute();
			} catch(PDOException $e) {
				die($e->getMessage());
			}
			
			// use fetchAll() instead of fetch() to get an array of all the selected records
			return $query->fetchAll();
		}
	}
?>