<?php include('includes/header.php'); ?>
    <div data-role="page" id="main-page" />
        <div data-role="content">
            <?php 
                if (isset($_GET['query'])) {  
                    $query = $_GET['query'];
                ?>
            <p><?php echo $query; ?></p>
            <?php } ?>
        </div>
    </div>
<?php include('includes/footer.php'); ?>