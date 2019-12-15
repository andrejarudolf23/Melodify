<?php
include("../../config.php");

if(isset($_POST['playlistId']) && isset($_POST['songId'])) {
   $playlistId = $_POST['playlistId'];
   $songId = $_POST['songId'];

   $playlistOrderQuery = mysqli_query($con, "SELECT MAX(playlistOrder) + 1 as highestOrder FROM playlistsongs WHERE playlistId='$playlistId'");
   $row = mysqli_fetch_array($playlistOrderQuery);
   $playlistOrder = $row['highestOrder'];
   
   if($playlistOrder == 0) {
      $playlistOrder = 1;
   }

   $query = mysqli_query($con, "INSERT INTO playlistsongs VALUES('', '$songId', '$playlistId', '$playlistOrder')");

}
else {
   "PlaylistId or songId not passed to addSongToPlaylist.php";
}

?>