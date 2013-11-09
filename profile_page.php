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
		<div data-role="content">
			<div class="ui-grid-a">
				<div class="ui-block-a"><img src="images/default_gravatar.png" class="ui-li-thumb" /></div>
				<div class="ui-block-b">
					<h1 class="ui-li-heading"><?php echo $user['user_name']; ?></h1>
					<div class="ui-grid-a">
						<p class="ui-block-a ui-li-desc">Joined: <?php echo date('F j, Y', $user['time']); ?></p>
						<p class="ui-block-b ui-li-desc"><?php echo $user['email']; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once('includes/footer.php'); ?>