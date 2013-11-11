<?php
	require_once('includes/init.php');
	$general->logged_in_protect();
	// If form is submitted
	if (isset($_POST['submit'])) {
	
		if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
			$errors[] = 'All fields are required';
		} else {
		
			// validating user's input with functions
			if ($users->user_exists($_POST['username']) == true) {
				$errors[] = 'That user name already exists';
			}
			
			if (!ctype_alnum($_POST['username']) == true) {
				$errors[] = 'Please enter a user name with only alphabets and numbers';
			}
			
			if (strlen($_POST['password']) < 6) {
				$errors[] = 'Your password must be at least 6 characters';
			} else if (strlen($_POST['password']) > 18) {
				$errors[] = 'Your password cannot be more than 18 characters long';
			}
			
			if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
				$errors[] = 'Please enter a valid email address';
			} else if ($users->email_exists($_POST['email']) == true) {
				$errors[] = 'That email already exists';
			}
		}
		
		if (empty($errors) == true) {
			
			$username 	= htmlentities($_POST['username']);
			$password 	= $_POST['password'];
			$email		= htmlentities($_POST['email']);
			
			$users->register($username, $password, $email);
			
			header('Location: register.php?success');
			exit();
		}
	}
	require_once('includes/header.php');
?>
	<div data-role="page" id="main-page">
		<?php require_once("includes/sidebar.php"); ?>
<?php
	if (isset($_GET['success']) && empty($_GET['success'])) {
        echo '<div data-role="content">';
		echo 'Thank you for registering. Please check your email.';
		echo '</div>';
        echo '<script>redirect_home();</script>';
	} else {
?>
		<div data-role="content">
			<form method="POST" action="">
				<ul data-role='listview'>
					<li>
						<input type='text' name='username' id='username' data-clear-btn='true' placeholder="Username" />
					</li>  
					<li>
						<input type='password' name='password' id='password' data-clear-btn='true' autocomplete="off" placeholder="Password" />
					</li>
					<li>
						<input type='text' name='email' id='email' data-clear-btn='true' placeholder="Email" />
					</li>
					<li>
						<button type='submit' name='submit'>Register</button>
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
		<?php } ?>
	</div>
<?php include('includes/footer.php'); ?>