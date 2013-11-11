<?php 
	include("includes/init.php");
	include("includes/header.php");
?>
    <div data-role="page" id="main-page">
		<?php require_once("includes/sidebar.php"); ?>
        <div data-role="content">
            <form id="main_search" action="search.php" method="GET">
                <div class="main_title">flicks</div>
                <input type="search" class="search_box" name="query"  data-mini="true" data-icon="search" data-iconpos="left" placeholder="search" />
            </form>
        </div>
    </div>
<?php include("includes/footer.php"); ?>