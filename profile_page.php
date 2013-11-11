<?php
	require_once('includes/init.php');
    
	$general->logged_out_protect();
	if (isset($_GET['user_id'])) {
		$user_id = $_GET['user_id'];
		$user = $users->userdata($_GET['user_id']);
	}
	
	require_once('includes/header.php');
?>
	<div data-role="page" id="main-page">
		<?php require_once("includes/sidebar.php"); ?>
		<div data-role="content">
			<div style="width: 100%">
				<div style="float: left; width: 30%"><img src="images/default_gravatar.png" class="ui-li-thumb" /></div>
				<div style="float: right; width: 70%;">
					<span><?php echo $user['user_name']; ?></span>
					<div>
						<p class="ui-li-desc">Joined: <?php echo date('F j, Y', $user['time']); ?></p>
						<p class="ui-li-desc"><?php echo $user['email']; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once('includes/footer.php'); ?>