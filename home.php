<?php
	require_once('includes/init.php');
	$general->logged_out_protect();
	
	require_once('includes/header.php');
	
	$user		= $users->userdata($_SESSION['user_id']);
	$username	= $user['user_name'];
?>
	<div data-role="page" id="main-page">
		<?php require_once("includes/sidebar.php"); ?>
        <div data-role="content">
			<ul data-role="listview">
				<li><a href="index.php">Search</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
			<h3>Hello <?php echo $username; ?>!</h3>
		</div>
	</div>
<?php
	require_once('includes/footer.php');
?>