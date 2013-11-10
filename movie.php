<?php
	require_once('includes/init.php');
	
	if (isset($_GET['id'])) {
		$movie_id = $_GET['id'];
	}
	
	require_once('includes/header.php');
?>
	<div data-role="page" id="main-page" />
        <div data-role="content">
			<div>
				<?php $rtdb->get_movie($movie_id); ?>
			</div>
        </div>
    </div>
<?php require_once('includes/footer.php');