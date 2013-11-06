<?php
	require_once('includes/init.php');
	
	$members		= $users->get_users();
	$member_count	= count($members);

	require_once('includes/header.php');
?>
	<div data-role="page" id="main-page">
		<div data-role="content">
			<ul data-role="listview" data-inset="false">
				<?php
					foreach ($members as $member) {
						echo '<li>
								<a href="profile_page.php?user_id=' . $member['user_id'] . '">
									<img src="images/default_gravatar.png" class="ui-li-thumb" />
									<h3 class="ui-li-heading">' . $member['user_name'] . '</h3>
									<p class="ui-li-desc">Joined: ' . date('F j, Y', $member['time']) . '</p>
								</a>
							  </li>';
					}
				?>
			</ul>
			
			<p>Total Members: <?php echo $member_count; ?> members</p>
		</div>
	</div>
<?php require_once('includes/footer.php'); ?>