<?php
	require_once("includes/init.php");
	require_once('includes/header.php');
    
    $general->logged_out_protect();
    
    if (isset($_GET['query'])) {  
        $query = $_GET['query'];
        $query = ltrim($query);
        $query = rtrim($query);
    }
	
?>
    <div data-role="page" id="main-page">
		<?php require_once("includes/sidebar.php"); ?>
        <div data-role="content">
			<div data-role="header" data-position="fixed" data-fullscreen="false" data-theme="c">
                <h3 class="search_title">Search: "<?php echo $query; ?>"</h3>
			</div>
			<?php 
			try {
				if ($requested_with != "com.imagine.flicks") {
					echo '<br /><br />';
				}
			} catch(Exception $e){}
			?>
            <ul data-role="listview" data-inset="false" data-split-icon="plus" data-split-theme="a">
                <?php 
					if ($general->logged_in())
						$rtdb->search_movie($query);
					else
						echo "Please Log In.";
				?>
            </ul>
        </div>
    </div>
<?php include('includes/footer.php'); ?>