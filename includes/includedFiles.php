<?php
//check whether the request was sent by ajax or the user manually went to that URL
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
   // echo "CAME FROM AJAX";
   include("includes/config.php");
   include("includes/classes/User.php");
   include("includes/classes/Artist.php");
   include("includes/classes/Album.php");
   include("includes/classes/Song.php");
   include("includes/classes/Playlist.php");

   if(isset($_GET['userLoggedIn'])) {
      $userLoggedIn = new User($con, $_GET['userLoggedIn']);
   }
   else {
      echo "Username variable was not passed into the page. Check openPage() JS function";
      exit();

   }
}
else {
   include("includes/header.php");
   include("includes/footer.php");

   $url = $_SERVER['REQUEST_URI'];
   echo "<script>openPage('$url')</script>";
   exit();
}


?>