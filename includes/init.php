<?php
	require_once('database.php');
	require_once('classes/users.php');
	require_once('classes/general.php');
	
	#starting the users session
	sec_session_start();
	
	$users		= new Users(connect_db());
	$general	= new General();
	
	$errors		= array();
	
?>