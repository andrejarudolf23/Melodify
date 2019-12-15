<?php
include("../../config.php");

if(!isset($_POST['username'])) {
   echo "ERROR: Username not set. Check updateEmail() function";
   exit();
}

if(isset($_POST['email']) && $_POST['email'] != "") {
   $email = $_POST['email'];
   $username = $_POST['username'];

   //check if the email is well-formed
   if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "Invalid email format";
      exit();
   }

   //check email availability
   $emailCheck = mysqli_query($con, "SELECT email FROM users WHERE email='$email' AND username != '$username'");
   if(mysqli_num_rows($emailCheck) > 0) {
      echo "Email is already taken";
      exit();
   }

   $updateEmailQuery = mysqli_query($con, "UPDATE users SET email='$email' WHERE username='$username'");
   echo "Email updated!";

}
else {
   echo "You must provide email.";
}

?>