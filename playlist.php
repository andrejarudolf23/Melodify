<?php
include("includes/includedFiles.php");

if(isset($_GET['id'])) {
   $playlistId = $_GET['id'];
}
else {
   header("Location: index.php");
}

//Get the playlist
$playlist = new Playlist($con, $playlistId);
//Get the owner
$owner = $playlist->getOwner();
?>

<div class="playlistInfo entityInfo">
   <div class="leftSection">
      <div class="playlistImage">
         <img src="assets/images/icons/playlist.png">
      </div>
   </div>
   <div class="rightSection">
      <h2><?php echo $playlist->getName(); ?></h2>
      <p>By <?php echo $playlist->getOwner(); ?></p>
      <p><?php echo $playlist->getNumberOfSongs(); ?> songs</p>
      <button class="btn" onclick="deletePlaylist('<?php  echo $playlistId; ?>')">DELETE PLAYLIST</button>
   </div>
</div>
<div class="tracklistContainer">
   <ul class="tracklist">
      <?php
         $playlistSongsIdArray = $playlist->getSongsIds(); 
         $i = 1;

         foreach($playlistSongsIdArray as $songId) {
            $playlistSong = new Song($con, $songId);
            $songArtist = $playlistSong->getArtist();

            echo "<li class='tracklistRow'>
                     <div class='trackCount'>
                        <img class='play' src='assets/images/icons/play-white.png' alt='play button' onclick='setTrack(\"" . $playlistSong->getId() . "\", tempPlaylist, true)'>
                        <span class='trackNumber'>$i</span>
                     </div>
                     <div class='trackInfo'>
                        <span class='trackName'>" . $playlistSong->getTitle() . "</span>
                        <span class='artistName'>" . $songArtist->getName() . "</span>
                     </div>
                     <div class='trackOptions'>
                        <input type='hidden' class='songId' value='" . $playlistSong->getId() . "'>
                        <img class='optionsButton' src='assets/images/icons/more.png' alt='options' onclick='showOptionsMenu(this)'>
                     </div>
                     <div class='trackDuration'>
                        <span class='duration'>" . $playlistSong->getDuration() . "</span>
                     </div>
                  </li>";
            $i++;
         }
      ?>

      <script>
         var tempSongIds = '<?php echo json_encode($playlistSongsIdArray); ?>';
         tempPlaylist = JSON.parse(tempSongIds);
         // console.log(tempSongIds);
         // console.log(tempPlaylist);
      </script>
   </ul>
</div>

<nav class="optionsMenu">
   <input type="hidden" class="songId">
   <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
   <div class="item" onclick="removeFromPlaylist(this, <?php echo $playlistId; ?>)">Remove from playlist</div>
</nav>