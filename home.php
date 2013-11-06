<?php
	require_once('includes/init.php');
	require_once('includes/header.php');
?>
	<div data-role="page" id="main-page">
		<div data-role="content">
			This is home
			<?php echo 'id = ' . $_SESSION['user_id']; ?>
		</div>
	</div>
<?php
	require_once('includes/footer.php');
?>