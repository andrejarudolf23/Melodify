<?php
include("includes/includedFiles.php");

if(isset($_GET['term'])) {
   $searchTerm = urldecode($_GET['term']);
}
else {
   $searchTerm = "";
}

?>

<div class="searchContainer">
   <h4>Search for an artist, album or song</h4>
   <input type="text" class="searchInput" value="<?php echo $searchTerm; ?>" placeholder="Start typing..." onkeyup="loadData()">
</div>

<script>
   //TODO: Fix the search box focus position - FIXED :)
   $.fn.setCursorPosition = function(pos) {
      this.each(function(index, elem) {
         if (elem.setSelectionRange) {
            elem.setSelectionRange(pos, pos);
         } else if (elem.createTextRange) {
            var range = elem.createTextRange();
            range.collapse(true);
            range.moveEnd('character', pos);
            range.moveStart('character', pos);
            range.select();
         }
      });
      return this;
   };

   var length = $(".searchInput").val().length;
   $(".searchInput").focus();
   $(".searchInput").setCursorPosition(length);

   var timer;

   function loadData() {
      
      clearTimeout(timer);
      timer = setTimeout(function() {
         // console.log("Hello");
         let value = document.querySelector('.searchInput').value;
         openPage('search.php?term=' + value);
      }, 800);      
      
   }

</script>

<?php if($searchTerm == "") exit(); ?>

<div class="tracklistContainer borderBottom">
   <h2>SONGS</h2>
   <ul class="tracklist">

      <?php
      $songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '$searchTerm%' LIMIT 10");

      if(mysqli_num_rows($songsQuery) == 0) {
         echo "<span class='noResults'>No songs found matching " . $searchTerm . "</span>";
      }

      $songIdArray = array();
      $i = 1;

      while($row = mysqli_fetch_array($songsQuery)) {
         if($i > 15) {
            break;
         }

         array_push($songIdArray, $row['id']);

         $albumSong = new Song($con, $row['id']);
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
         var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
         tempPlaylist = JSON.parse(tempSongIds);
         // console.log(tempSongIds);
         // console.log(tempPlaylist);
      </script>
   </ul>
</div>

<div class="artistsContainer borderBottom">
   <h2>ARTISTS</h2>

   <?php
   $artistsQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '$searchTerm%' LIMIT 10");
   if(mysqli_num_rows($artistsQuery) == 0) {
      echo "<span class='noResults'>No artists found matching " . $searchTerm . "</span>";
   }

   while($row = mysqli_fetch_array($artistsQuery)) {
      $artist = new Artist($con, $row['id']);

      echo "<div class='searchResultRow'>
               <div class='artistName'>
                  <span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artist->getId() . "\")'>
                     " . $artist->getName() . "
                  </span>
               </div> 
            </div>";
   }
   
   ?>
</div>
<div class="gridViewContainer">
   <h2>ALBUMS</h2>
	<?php
      $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '$searchTerm%'");
      if(mysqli_num_rows($albumQuery) == 0) {
         echo "<span class='noResults'>No albums found matching " . $searchTerm . "</span>";
      }

		while($row = mysqli_fetch_array($albumQuery)) {

			echo "<div class='gridViewItem'>
						<span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
							<img src='" . $row['artworkPath'] . "'>
							<div class='gridViewInfo'>" . $row['title'] . "</div>
						</span>
					</div>";
		}
	?>
</div>
<nav class="optionsMenu">
   <input type="hidden" class="songId">
   <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>