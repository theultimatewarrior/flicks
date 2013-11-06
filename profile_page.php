<?php
	require_once('includes/init.php');
	//$user = $users->userdata($_SESSION['user_id']);
	
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
				<div class="ui-block-b"><h3 class="ui-li-heading"><?php echo $user['user_name']; ?></h3></div>
			</div>
		</div>
	</div>
<?php require_once('includes/footer.php'); ?>