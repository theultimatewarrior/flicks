<?php
	//if ($detect->isMobile() && $_SERVER['HTTP_X_REQUESTED_WITH'] == "com.imagine.flicks") {
	//} else {
?>
		<div data-role="header" class="header" data-position="fixed" data-theme="a">
			<a id="navigation-button" href="#panel-nav" data-icon="bars" data-iconpos="notext">Navigation</a>
			<h1 class="main_title" <?php if (!$detect->isMobile()) { ?>style="text-align: left !important; margin: 0.6em 1em -2em 50px !important;" <?php } ?>>
                <a style="color: #F5F5F5;" href="index.php">flicks</a>
            </h1>
            <?php if (!$detect->isMobile()) { ?>
            <form style="margin: 0.6em 1em -2em 55%; width: 40%;" action="search.php" method="GET">
                <input data-mini="true" name="query" type="search" placeholder="search movie"/>
            </form>
            <h1>&nbsp;</h1>
            <?php }
				if ($general->logged_in()) {
			?>
			<a id="user-nav-button" href="#panel-nav" data-icon="grid" data-iconpos="notext">User Profile</a>
			<?php } ?>
		</div>
		
		<div data-role="panel" id="left-panel" data-theme="a">
			<form action="search.php" method="GET">
				<input type="search" name="query" id="search-mini" value="" data-mini="true" data-icon="search" data-iconpos="left" placeholder="search..." />
			</form>
			<br />
			<ul data-role='listview' data-insert='true' class='ui-icon-alt' data-theme="a" data-divider-theme="a">
				<li><a href='index.php'>Flicks</a></li>	
				<li><a href='home.php'>Home</a></li>	
				<li><a href=''>Show Times</a></li>	
				<li><a href='members.php'>Members</a></li>
			</ul><br />
			
			<?php if (!$general->logged_in()) { ?>
			<div class="ui-grid-a">
				<div class="ui-block-a">
					<a href="login.php" data-role="button" data-mini="true">Log-in</a>
				</div>
				<div class="ui-block-b">
					<a href="register.php" data-role="button" data-theme="b" data-mini="true" style="color: #FFFFFF;">Sign up</a>
				</div>
			</div>
			<?php } ?>
		</div>
		
		<div data-role="panel" id="right-panel" data-theme="b" data-position="right">
			<?php // if get_user_profile_pic_url_exists ?>
			<!--<img src="' .  //get_user_profile_pic_url . '" />-->
			<?php //else ?>
			<div class="ui-grid-a">
				<div class="ui-block-a"><a href="profile_page.php?user_id=<?php echo $_SESSION['user_id']; ?>"><img class="small_profile_pic" src="images/default_gravatar.png" /></a></div>
				<div class="ui-block-b small_user_info">
					<a class="small_user_info_content" href="profile_page.php?user_id=<?php echo $_SESSION['user_id']; ?>"><?php //echo $_SESSION['firstName'] . ' ' . $_SESSION['lastName']; ?></a>
				</div>
			</div>
			<br />
			<ul data-role='listview' data-insert='true' class='ui-icon-alt' data-theme="a" data-divider-theme="a">
				<li><a href='profile_page.php?user_id=<?php echo $_SESSION['user_id']; ?>'>Edit Profile</a></li>	
				<li><a href=''>My Flicks</a></li>
				<li><a href='logout.php'>Log Out</a></li>
			</ul>
		</div>
<?php
	//}
?>