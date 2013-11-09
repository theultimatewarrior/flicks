<?php
	
	define("DB_SERVER", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_NAME", "flicks");
    
    define("CLS_PATH", "classes/");
    
    function connect_db() {
    
        try {
            $db = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        
        return $db;
    }
    
    /*
     * Secure Session Start
     */
    function sec_session_start() {
        
        $session_name = 'sec_session_id';           // Set a custom session name
        $secure = false;                            // Set to true if using https
        $httponly = true;                           // This stops javascript being able to access the session id
        
        ini_set('session.use_only_cookies', 1);     // Forces sessions to only use cookies
        $cookieParams = session_get_cookie_params();// Gets current cookies params
        $cookieParams = session_get_cookie_params();// Gets current cookies params.
        
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"],  $cookieParams["domain"], $secure, $httponly); 
        session_name($session_name);                // Sets the session name to the one set above
        //session_save_path("/home/users/web/b89/moo.nguyenho/cgi-bin/tmp"); // Needed for fatcow.com
        session_start();                                    // Start the php session
        session_regenerate_id();                    // regenerated the session, delete the old one
    }
	
?>