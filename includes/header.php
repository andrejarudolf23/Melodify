<?php
include("config.php");
include("classes/Artist.php");
include("classes/Album.php");
include("classes/Song.php");

if(isset($_SESSION['userLoggedIn'])) {
	$userLoggedIn = $_SESSION['userLoggedIn'];
}
else {
	header("Location: register.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Melodify</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
   <div id="mainContainer">
      <div id="topContainer">
			<?php include ("includes/navBarContainer.php"); ?>
			<div id="mainViewContainer">
				<div id="mainContent">