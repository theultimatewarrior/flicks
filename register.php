<?php
	require_once('includes/header.php');
	
	// If form is submitted
	if (isset($_POST['submit'])) {
	
		if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
			$errors[] = 'All fields are required.';
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
				$errors[] = 'Please enter a valid email address.';
			} else if ($users->email_exists($_POST['email']) == true) {
				$errors[] = 'That email already exists.';
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
?>
	<div data-role="page" id="main-page">
<?php
	if (isset($_GET['success']) && empty($_GET['success'])) {
        echo '<div data-role="content">';
		echo 'Thank you for registering. Please check your email.';
		echo '</div>';
	} else {
?>
		<div data-role="content">
			<form method="POST" action="">
				<ul data-role='listview'>
					<li>
						<label for='username'>Username</label>
						<input type='text' name='username' id='username' data-clear-btn='true' />
					</li>  
					<li>
						<label for='password'>Password</label>
						<input type='password' name='password' id='password' data-clear-btn='true' autocomplete="off" />
					</li>
					<li>
						<label for='email'>Email</label>
						<input type='text' name='email' id='email' data-clear-btn='true'/>
					</li>
					<li>
						<button type='submit' name='submit'>Register</button>
					</li>
				</ul>
			</form>
			
			<?php
				// Display errors here
				if (empty($errors) == false) {
					echo '<p>' . implode('</p><p>', $errors) . '</p>';
				}
			?>
		</div>
		<?php } ?>
	</div>
<?php include('includes/footer.php'); ?>