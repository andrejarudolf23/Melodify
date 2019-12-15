<?php
include("includes/config.php");
include("includes/classes/User.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");
include("includes/classes/Playlist.php");

if(isset($_SESSION['userLoggedIn'])) {
	$username = $_SESSION['userLoggedIn'];
	$userLoggedIn = new User($con, $username);
	echo "<script>userLoggedIn = '$username';</script>";
}
else {
	header("Location: register.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Melodify</title>
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<!-- jQuery -->
	<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <!-- Main JS -->
	<script src="assets/js/main.js"></script>
</head>
<body>
   <div id="mainContainer">
      <div id="topContainer">
			<?php include ("includes/navBarContainer.php"); ?>
			<div id="mainViewContainer">
				<div id="mainContent">