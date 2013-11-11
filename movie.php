<?php
	require_once('includes/init.php');
	
	if (isset($_GET['id'])) {
		$movie_id = $_GET['id'];
	}
	
	require_once('includes/header.php');
?>
	<div data-role="page" id="main-page">
		<?php require_once("includes/sidebar.php"); ?>
        <div data-role="content">
			<?php $rtdb->get_movie($movie_id); ?>
        </div>
    </div>
<?php require_once('includes/footer.php');