<?php include ("includes/includedFiles.php");

if(isset($_GET['id'])) {
   $albumId = $_GET['id'];
}
else {
   header("Location: index.php");
}
//Get the album
$album = new Album($con, $albumId);
//Get the artist of the album
$artist = $album->getArtist();
?>

<div class="albumInfo entityInfo">
   <div class="leftSection">
      <img src="<?php echo $album->getArtworkPath(); ?>" alt="album pic">
   </div>
   <div class="rightSection">
      <h2><?php echo $album->getTitle(); ?></h2>
      <p>By <?php echo $artist->getName(); ?></p>
      <p><?php echo $album->getNumberOfSongs(); ?> songs</p>
   </div>
</div>
<div class="tracklistContainer">
   <ul class="tracklist">
      <?php
         $albumSongsIdArray = $album->getSongsIds(); 
         $i = 1;
         foreach($albumSongsIdArray as $songId) {
            $albumSong = new Song($con, $songId);
            $albumArtist = $albumSong->getArtist();

            echo "<li class='tracklistRow'>
                     <div class='trackCount'>
                        <img class='play' src='assets/images/icons/play-white.png' alt='play button' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
                        <span class='trackNumber'>$i</span>
                     </div>
                     <div class='trackInfo'>
                        <span class='trackName'>" . $albumSong->getTitle() . "</span>
                        <span class='artistName'>" . $albumArtist->getName() . "</span>
                     </div>
                     <div class='trackOptions'>
                        <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                        <img class='optionsButton' src='assets/images/icons/more.png' alt='options' onclick='showOptionsMenu(this)'>
                     </div>
                     <div class='trackDuration'>
                        <span class='duration'>" . $albumSong->getDuration() . "</span>
                     </div>
                  </li>";
            $i++;
         }
      ?>

      <script>
         var tempSongIds = '<?php echo json_encode($albumSongsIdArray); ?>';
         tempPlaylist = JSON.parse(tempSongIds);
         // console.log(tempSongIds);
         // console.log(tempPlaylist);
      </script>
   </ul>
</div>

<nav class="optionsMenu">
   <input type="hidden" class="songId">
   <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>


