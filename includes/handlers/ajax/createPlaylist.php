<?php
include("../../config.php");

if(isset($_POST['playlistName']) && isset($_POST['owner'])) {

   $playlistName = $_POST['playlistName'];
   $owner = $_POST['owner'];
   $dateCreated = date("Y-m-d H:i:s");

   $query = mysqli_query($con, "INSERT INTO playlists VALUES ('', '$playlistName', '$owner', '$dateCreated')");
}
else {
   echo "Name or username parameters not passed into file";
}

?>