<?php
	include("includes/config.php");
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");

	$account = new Account($con);

	include ("includes/handlers/register-handler.php");
	include ("includes/handlers/login-handler.php");

	function getInputValue($input) {
		if(isset($_POST[$input]))
			echo $_POST[$input];
	}    
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Melodify</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">
	<script
	  src="https://code.jquery.com/jquery-3.4.1.min.js"
	  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
	  crossorigin="anonymous">
	</script>
	<script src="assets/js/register.js"></script>
</head>
<body>
	<?php

		if(isset($_POST['registerButton'])) {
			echo '<script>
					$(document).ready(function() {
						$("#loginForm").hide();
						$("#registerForm").show();
					});
				</script>';
		}
		else {
			echo '<script>
					$(document).ready(function() {
						$("#loginForm").show();
						$("#registerForm").hide();
					});
				</script>';
		}

	?>
	<div class="logo">
		<img src="assets/images/icons/Melodify-logo-white.png">
	</div>
	

	<div id="background">

		<div id="loginContainer">

			<div id="inputContainer">
				<form id="loginForm" action="register.php" method="POST">
					<h2>Login to your account</h2>
					<p>
						<?php echo $account->getError(Constants::$loginFailed); ?>
						<label for="loginUsername">Username</label>
						<input type="text" name="loginUsername" id="loginUsername" required="" autocomplete="off" value="<?php getInputValue("loginUsername") ?>">
					</p>
					<p>
						<label for="loginPassword">Password</label>
						<input type="password" name="loginPassword" id="loginPassword" required="">
					</p>
					
					<button type="submit" name="loginButton">LOG IN</button>

					<div class="hasAccountText">
						<span id="hideLogin">Don't have an account yet? Sign up here</span>
					</div>
					
				</form>


				<form id="registerForm" action="register.php" method="POST">
					<h2>Create your free acount</h2>
					<p>
						<?php echo $account->getError(Constants::$usernameLength); ?>
						<?php echo $account->getError(Constants::$usernameTaken); ?>
						<label for="registerUsername">Username</label>
						<input type="text" name="registerUsername" id="registerUsername" value="<?php getInputValue("registerUsername") ?>" required="" autocomplete="off">
					</p>

					<p>
						<?php echo $account->getError(Constants::$firstNameLength); ?>
						<label for="firstName">First name</label>
						<input type="text" name="firstName" id="firstName" value="<?php getInputValue("firstName") ?>" required="">
					</p>

					<p>
						<?php echo $account->getError(Constants::$lastNameLength); ?>
						<label for="lastName">Last name</label>
						<input type="text" name="lastName" id="lastName" value="<?php getInputValue("lastName") ?>" required="">
					</p>

					<p>
						<?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
						<?php echo $account->getError(Constants::$emailInvalid); ?>
						<?php echo $account->getError(Constants::$emailTaken); ?>
						<label for="email">Email</label>
						<input type="email" name="email" id="email" value="<?php getInputValue("email") ?>" required="">
					</p>

					<p>
						<label for="email2">Confirm Email</label>
						<input type="email" name="email2" id="email2" value="<?php getInputValue("email2") ?>" required="">
					</p>

					<p>
						<?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
						<?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
						<?php echo $account->getError(Constants::$passwordLength); ?>
						<label for="registerPassword">Password</label>
						<input type="password" name="registerPassword" id="registerPassword" required="">
					</p>

					<p>
						<label for="registerPassword2">Confirm password</label>
						<input type="password" name="registerPassword2" id="registerPassword2" required="">
					</p>
					
					<button type="submit" name="registerButton">SIGN UP</button>

					<div class="hasAccountText">
						<span id="hideRegister">Already have an account? Log in here</span>
					</div>
					
				</form>

			</div>

			<div id="loginText">
				<h1>Melodify</h1>
				<h2>Listen to loads of songs for free</h2>
				<ul>
					<li>Discover music you'll fall in love with</li>
					<li>Create your own playlists</li>
					<li>Follow artists to keep up to date</li>
				</ul>
				
			</div>

			

		</div>
	</div>

</body>
</html>