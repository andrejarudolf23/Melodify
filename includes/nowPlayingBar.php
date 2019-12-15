<?php
   //create a random playlist with 10 random songs
   $query = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
   $resultArray = array();

   while($row = mysqli_fetch_array($query)) {
      array_push($resultArray, $row['id']);
   }

   //playlist variable
   $jsonArray = json_encode($resultArray);
?>

<script>
   
$(document).ready(function() {
   let newPlaylist = <?php echo $jsonArray; ?>;
   audioElement = new Audio();
   setTrack(newPlaylist[0], newPlaylist, false);
   updateVolumeProgressBar(audioElement.audio);

   //preventing controls from highlighting on mouse drag
   $('#nowPlayingCenter, #nowPlayingRight').on("mousedown touchstart mousemove touchmove", function(e) {
      e.preventDefault();
   });

   let songProgressBar = document.querySelector('.playbackBar .progressBar');
   let volumeProgressBar = document.querySelector('.volumeBar .progressBar');

   songProgressBar.onmousedown = function() {
      mouseDown = true;
      // console.log("Mousedown inside song progress bar is working!");
   }

   songProgressBar.onmousemove = function(e) {
      if(mouseDown) {
         //Skipping forwards or backwards in song
         timeFromOffset(e, this);
         // console.log("moving inside song bar is working");
      }
   }

   songProgressBar.onmouseup = function(e) {
      timeFromOffset(e, this);
   }

   volumeProgressBar.onmousedown = function() {
      mouseDown = true;
   }

   volumeProgressBar.onmousemove = function(e) {
      if(mouseDown) {
         handleVolume(e, this);
         // console.log("moving inside volume bar is working");
      }
   }

   volumeProgressBar.onmouseup = function(e) {
      handleVolume(e, this);
   }

   document.onmouseup = function() {
      mouseDown = false;
   }
   
});

function handleVolume(mouse, volumeProgressBar) {
   let percentage = mouse.offsetX / volumeProgressBar.offsetWidth;
   if(percentage >= 0 && percentage <= 1) {
      audioElement.audio.volume = percentage;
   }
}

//time of the song from the offset of the mouse
function timeFromOffset(mouse, progressBar) {
   let percentage = mouse.offsetX / progressBar.offsetWidth * 100;
   let seconds = audioElement.audio.duration * (percentage / 100);
   audioElement.setTime(seconds);
   // console.log(percentage);
}

function nextSong() {
   if(repeat == true) {
      audioElement.setTime(0);
      playSong();
      return;
   }

   if(currentSongIndex == currentPlaylist.length - 1) {
      currentSongIndex = 0
   }
   else {
      currentSongIndex++;
   }

   let trackToPlay = shuffle ? shufflePlaylist[currentSongIndex] : currentPlaylist[currentSongIndex];
   setTrack(trackToPlay, currentPlaylist, true);
}

function previousSong() {
   if(currentSongIndex == 0 || audioElement.audio.currentTime >= 3) {
      //start the same song again
      audioElement.setTime(0);
   }
   else {
      //start the previous song in the playlist
      currentSongIndex--;
      let trackToPlay = shuffle ? shufflePlaylist[currentSongIndex] : currentPlaylist[currentSongIndex];
      setTrack(trackToPlay, currentPlaylist, true);
   }
}

function setRepeat() {
   repeat = !repeat; //if true, set it to false/if false set it to true
   let imageName;
   let repeatBtn = document.querySelector('.controlButton.repeat img');

   if(repeat) {
      imageName = "repeat-active.png";
   }
   else {
      imageName = "repeat.png";
   }

   repeatBtn.src = "assets/images/icons/" + imageName;
}

function muteVolume() {
   audioElement.audio.muted = !audioElement.audio.muted; //If its muted then UNMUTE it, otherwise MUTE it

   if(audioElement.audio.muted) {
      document.querySelector('.controlButton.volume img').src = "assets/images/icons/volume-mute.png"; 
   }
   else {
      document.querySelector('.controlButton.volume img').src = "assets/images/icons/volume.png";
   }
}

function setShuffle() {
   shuffle = !shuffle; 
   let shuffleBtn = document.querySelector('.controlButton.shuffle img');
   let imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
   shuffleBtn.src = 'assets/images/icons/' + imageName;

   if(shuffle) {
      //shuffle playlist
      shuffleArray(shufflePlaylist);
      //set the current index to be wherever the currently playing song is in shufflePlaylist
      currentSongIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
   }
   else {
      //shuffle deactivated
      //go back to regular playlist
      currentSongIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
   }
}

function shuffleArray(a) {
    var j, x, i;
    for (i = a.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = a[i];
        a[i] = a[j];
        a[j] = x;
    }
    return a;
}

function setTrack(trackId, newPlaylist, play) {

   if(newPlaylist != currentPlaylist) {
      currentPlaylist = newPlaylist;
      //create copy of the current playlist
      shufflePlaylist = currentPlaylist.slice();
      shuffleArray(shufflePlaylist);
   }

   if(shuffle) {
      currentSongIndex = shufflePlaylist.indexOf(trackId);
   }
   else {
      currentSongIndex = currentPlaylist.indexOf(trackId);
   }
   pauseSong();

   //ajax call to get song
   $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {

      let track = JSON.parse(data);
      $(".trackDetails .songName span").text(track.title);
      $(".trackDetails .songName span").attr("onclick", "openPage('album.php?id=" + track.album + "')");

       //ajax call to get artist
      $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data) {
         let author = JSON.parse(data);
         $(".trackDetails .songAuthor span").text(author.name);
         $(".trackDetails .songAuthor span").attr("onclick", "openPage('artist.php?id=" + author.id + "')");
      });

      //ajax call to get album
      $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {
         let album = JSON.parse(data);
         $(".content .albumLink img").attr("src", album.artworkPath);
         $(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
      });
      
      audioElement.setSong(track);

         if(play) {
         playSong();
      }
   })

}

function playSong() {
   
   if(audioElement.audio.currentTime == 0) {
      // console.log("UPDATE PLAY COUNT");
      //ajax call to update song plays count
      $.post("includes/handlers/ajax/updateSongPlaysCount.php", { songId: audioElement.currentlyPlaying.id });
   }
   else {
      // console.log("DONT UPDATE PLAY COUNT");
   }

   $(".controlButton.play").hide();
   $(".controlButton.pause").show();
   audioElement.playAudio();
}

function pauseSong() {
   $(".controlButton.pause").hide();
   $(".controlButton.play").show();
   audioElement.pauseAudio();
}

</script>

<div id="nowPlayingBarContainer">
   <div id="nowPlayingBar">
      <div id="nowPlayingLeft">
         <div class="content">
            <span class="albumLink">
               <img role="link" tabindex="0" src="" class="albumArtwork">
            </span>
            <div class="trackDetails">
               <span class="songName">
                  <span role="link" tabindex="0"></span>
               </span>
               <span class="songAuthor">
                  <span role="link" tabindex="0"></span>
               </span>
            </div>
         </div>
      </div> 
      <div id="nowPlayingCenter">
         <div class="content playerControls">
            <div class="buttons">
               <button class="controlButton shuffle" alt="shuffle button" title="Shuffle button" onclick="setShuffle()">
                  <img src="assets/images/icons/shuffle.png">
               </button>
               <button class="controlButton previous" alt="previous button" title="Previous button" onclick='previousSong()'>
                  <img src="assets/images/icons/previous.png">
               </button>
               <button class="controlButton play" alt="play button" title="Play button" onclick="playSong()"> 
                  <img src="assets/images/icons/play.png">
               </button>
               <button class="controlButton pause" style="display: none;" alt="pause button" title="Pause button" onclick="pauseSong()">
                  <img src="assets/images/icons/pause.png">
               </button>
               <button class="controlButton next" alt="next button" title="Next button" onclick="nextSong()">
                  <img src="assets/images/icons/next.png">
               </button>
               <button class="controlButton repeat" alt="repeat button" title="Repeat button" onclick="setRepeat()">
                  <img src="assets/images/icons/repeat.png">
               </button>
            </div>
            <div class="playbackBar">
               <span class="progressTime current">0.00</span>
               <div class="progressBar">
                  <div class="progressBarBg">
                     <div class="progress"></div>
                  </div>
               </div>
               <span class="progressTime remaining">0.00</span>
            </div>
         </div>
      </div>
      <div id="nowPlayingRight">
         <div class="volumeBar">
            <button class="controlButton volume" title="Volume button" alt="volume button" onclick="muteVolume()">
               <img src="assets/images/icons/volume.png">
            </button>
            <div class="progressBar">
               <div class="progressBarBg">
                  <div class="progress"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>