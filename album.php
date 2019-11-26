<?php include ("includes/header.php");

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

<div class="albumInfo">
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
         $songIdArray = $album->getSongsIds(); 
         $i = 1;
         foreach($songIdArray as $songId) {
            $albumSong = new Song($con, $songId);
            $albumArtist = $albumSong->getArtist();

            echo "<li class='tracklistRow'>
                     <div class='trackCount'>
                        <img class='play' src='assets/images/icons/play-white.png' alt='play button'>
                        <span class='trackNumber'>$i</span>
                     </div>
                     <div class='trackInfo'>
                        <span class='trackName'>" . $albumSong->getTitle() . "</span>
                        <span class='artistName'>" . $albumArtist->getName() . "</span>
                     </div>
                     <div class='trackOptions'>
                        <img class='optionsButton' src='assets/images/icons/more.png' alt='options'>
                     </div>
                     <div class='trackDuration'>
                        <span class='duration'>" . $albumSong->getDuration() . "</span>
                     </div>
                  </li>";
            $i++;
         }
      ?>
   </ul>
</div>
<?php include ("includes/footer.php") ?>