<?php include("includes/includedFiles.php"); ?>

<div class="playlistsContainer">
   <div class="gridViewContainer">
      <h2>PLAYLISTS</h2>
      <div class="buttonItems">
         <button class="btn btn-green" onclick="createPlaylist()">NEW PLAYLIST</button>

         <?php
            $owner = $userLoggedIn->getUsername();
            $playlistsQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner='$owner'");

            if(mysqli_num_rows($playlistsQuery) == 0) {
               echo "You don't have any playlists yet.";
            }

            while($row = mysqli_fetch_array($playlistsQuery)) {
               $playlist = new Playlist($con, $row['id']);

               echo "<div class='gridViewItem' role='link' tabindex='0' 
                     onclick='openPage(\"playlist.php?id=" . $playlist->getId() . "\")'>
                        <div class='playlistImage'>
                           <img src='assets/images/icons/playlist.png'>
                        </div>
                        <div class='gridViewInfo'>" . $playlist->getName() . "</div>
                     </div>";

            }
         ?>

      </div>      
   </div>
</div>
