<?php
	include("includes/init.php");
	include('includes/header.php');
    
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
                <h1>Search: "<?php echo $query; ?>"</h1>
            </div>
            <ul data-role="listview" data-inset="false">
                <?php $rtdb->search_movie($query); ?>
            </ul>
        </div>
    </div>
<?php include('includes/footer.php'); ?>