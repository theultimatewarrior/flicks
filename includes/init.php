<?php
	require_once('database.php');
	require_once('classes/users.php');
	require_once('classes/general.php');
	require_once('classes/rtdb.php');
	
	#starting the users session
	sec_session_start();
	
	$users		= new Users(connect_db());
	$general	= new General();
    $rtdb       = new RTDb();
	
	$errors		= array();
	
?>