<?php 
	require_once("Mobile_Detect.php");
	$detect = new Mobile_Detect();
	
	$requested_with = null;
	if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
		$requested_with = $_SERVER['HTTP_X_REQUESTED_WITH'];
	}
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>My Flicks</title>
    
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
    <link rel="stylesheet" href="css/main.css" type="text/css" />
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
    <script src="js/script.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>