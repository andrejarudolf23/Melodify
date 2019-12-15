<?php
include("../../config.php");

if(!isset($_POST['username'])) {
   echo "Username variable not passed. Check updatePassword()";
   exit();
}

if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2'])) {
   echo "Not all password variables have been set. Check updatePassword()";
   exit();
}

if($_POST['oldPassword'] == "" || $_POST['newPassword1'] == ""  || $_POST['newPassword2'] == "") {
   echo "Please fill in all fields";
   exit();   
}

$username = $_POST['username'];
$oldPassword = $_POST['oldPassword'];
$newPassword1  = $_POST['newPassword1'];
$newPassword2 = $_POST['newPassword2'];

$dbPasswordQuery = mysqli_query($con, "SELECT password FROM users WHERE username='$username'");
$row = mysqli_fetch_array($dbPasswordQuery);
$dbPassword = $row['password'];

//check if the old password is equal to old db password
if(md5($oldPassword) !== $dbPassword) {
   echo "Your old password is incorrect. Please try again.";
   exit();
}

if($newPassword1 !== $newPassword2) {
   echo "Your new passwords do not match.";
   exit();
}

//check if the new passwords contain anything other than letters and numbers
if(preg_match('/[^A-Za-z0-9]/', $newPassword1)) {
   echo "Your password must only contain letters and/or numbers";
   exit();
}

if(strlen($newPassword1) > 30 || strlen($newPassword1) <5) {
   echo "Your password must be between 5 and 30 characters long";
   exit();
}

$encryptedPw = md5($newPassword1);
$updatePasswordQuery = mysqli_query($con, "UPDATE users set password='$encryptedPw' WHERE username='$username'");
echo "Password succesfully updated!";



?>