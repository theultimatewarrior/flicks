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
    <div data-role="page" id="main-page" />
        <div data-role="content">
            <div data-role="header" data-position="fixed">
                <span class="search_title">Search: "<?php echo $query; ?>"</span>
            </div>
            <ul data-role="listview" data-inset="false" data-split-icon="plus" data-split-theme="a">
                <?php $rtdb->search_movie($query); ?>
            </ul>
        </div>
    </div>
<?php include('includes/footer.php'); ?>