<?php
	require_once('includes/init.php');
	$general->logged_in_protect();
	
	if (empty($_POST) == false) {
		
		$login 		= trim($_POST['login']);
		$password	= trim($_POST['password']);
		
		if (empty($login) == true || empty($password) == true) {
			$errors[] = 'Sorry, but we need your user name and password';
		} else if ($users->user_exists($login) == false) {
			$errors[] = 'Sorry that user name doesn\'t exist';
		/*} else if ($users->email_confirmed($login) == false) {
			$errors[] = 'Sorry, but you need to activate your account. Please check your email';*/
		} else {
			$login_id = $users->login($login, $password);
			if ($login_id == false) {
				$errors[] = 'Sorry, that user name/password is invalid';
			} else {
				$_SESSION['user_id'] = $login_id;
				// Redirect to home.php
				header('Location: home.php');
				exit();
			}
		}
	}
	require_once("includes/header.php");
?>
	<div data-role="page" id="main-page">
		<div data-role="content">
			<form method="POST" action="">
				<ul data-role='listview'>
					<li>
						<label for='login'>Username</label>
						<input type='text' name='login' id='login' data-clear-btn='true' placeholder="username" />
					</li>  
					<li>
						<label for='password'>Password</label>
						<input type='password' name='password' id='password' data-clear-btn='true' autocomplete="off" placeholder="password" />
					</li>
					<li>
						<button type='submit' name='submit'>Log In</button>
					</li>
					<?php
						// Display errors here
						if (empty($errors) == false) {
							echo '<li>' . implode('</li><li>', $errors) . '</li>';
						}
					?>
				</ul>
			</form>
		</div>
	</div>
<?php require_once("includes/footer.php");