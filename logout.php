<?php
	require_once('includes/init.php');
    
    // Unset all session values
    $_SESSION = array();
    
    // get session parameters 
    $params = session_get_cookie_params();
    
    // Delete the actual cookie.
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    
	session_destroy();
	header('Location: index.php');
?>