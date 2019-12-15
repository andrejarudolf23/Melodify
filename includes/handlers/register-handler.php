<?php

function sanitizeFormUsername($inputText) {
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	return $inputText;
}

function sanitizeFormString($inputText) {
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	$inputText = ucfirst(strtolower($inputText));
	return $inputText;
}

function sanitizeFormEmail($input) {
	$input = strip_tags($input);
	$input = str_replace(" ", "", $input);

	return $input;
}

function sanitizeFormPassword($inputText) {
	$inputText = strip_tags($inputText);
	return $inputText;
}


if(isset($_POST['registerButton'])) {

	$username = sanitizeFormUsername($_POST['registerUsername']);
	$firstName = sanitizeFormString($_POST['firstName']);
	$lastName = sanitizeFormString($_POST['lastName']);
	$email = sanitizeFormEmail($_POST['email']);
	$email2 = sanitizeFormEmail($_POST['email2']);
	$password = sanitizeFormPassword($_POST['registerPassword']);	
	$password2 = sanitizeFormPassword($_POST['registerPassword2']);	

	$wasSuccesful = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2);

	if($wasSuccesful == true) {
		$_SESSION['userLoggedIn'] = $username;
		header("Location: index.php");
	}
	
}


?>