let currentPlaylist = [];
let shufflePlaylist = [];
let tempPlaylist = [];
let audioElement;
let mouseDown = false;
let currentSongIndex;
let repeat = false;
let shuffle = false;
var userLoggedIn;

window.onscroll = function(e) {
   this.hideOptionsMenu();
}

document.onclick = function(click) {
   var target = click.target;

   if(!target.classList.contains("optionsButton") && !target.classList.contains("item")) {
      hideOptionsMenu();
   }

}

$(document).on("change", "select.playlist", function() {
   var playlist = $(this);
   var playlistId = playlist.val();
   var songId = playlist.prev(".songId").val();

   $.post("includes/handlers/ajax/addSongToPlaylist.php", { playlistId: playlistId, songId: songId })
   .done(function(error) {

      if(error != "") {
         alert(error);
         return;
      }

      hideOptionsMenu();
      playlist.val("");

   });
});

function logout() {
   $.post("includes/handlers/ajax/logout.php", function() {
      location.reload();
   })
}

function updateEmail(emailClass) {
   var emailValue = $("." + emailClass).val();
   // console.log(emailValue);

   $.post("includes/handlers/ajax/updateEmail.php", { email: emailValue, username: userLoggedIn })
   .done(function(response) {
      $("." + emailClass).nextAll(".message").text(response);
   })

}

function updatePassword(oldPasswordClass, newPasswordClass1, newPasswordClass2) {
   var oldPassword = $("." + oldPasswordClass).val();
   var newPassword1 = $("." + newPasswordClass1).val();
   var newPassword2 = $("." + newPasswordClass2).val();

   $.post("includes/handlers/ajax/updatePassword.php", { oldPassword: oldPassword, newPassword1: newPassword1, newPassword2: newPassword2, username: userLoggedIn }).done(function(response) {

      $("." + newPasswordClass2).nextAll(".message").text(response);
      $(".pw").val('');
      
   })

}

function openPage(url) {

   if(url.indexOf("?") == -1) {
      url = url + "?";
   }

   let encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
   $("#mainContent").load(encodedUrl);
   $("body").scrollTop(0);
   history.pushState(null, null, url);
}

function createPlaylist() {
   var popup = prompt("Please enter the name of your playlist");

   if(popup != null) {

      $.post("includes/handlers/ajax/createPlaylist.php", { playlistName: popup, owner: userLoggedIn })
      .done(function(error) {

         if(error != "") {
            alert(error);
            return;
         }
         
         //refresh the page
         openPage('yourMusic.php');
      })
   }
}

function deletePlaylist(playlistId) {
   var box = confirm("Are you sure you want to delete this playlist?");

   if(box == true) {
      
      $.post("includes/handlers/ajax/deletePlaylist.php", { playlistId: playlistId })
      .done(function(error) {

         if(error != "") {
            alert(error);
            return;
         }

         openPage('yourMusic.php');
      });

   }
}

function removeFromPlaylist(button, playlistId) {
   var button = $(button);
   var songId = button.prevAll(".songId").val();

   $.post("includes/handlers/ajax/removeFromPlaylist.php", { playlistId: playlistId, songId: songId })
   .done(function(error) {
      if(error != "") {
         alert(error);
         return;
      }

      hideOptionsMenu();
      openPage('playlist.php?id=' + playlistId);
   })
}

function showOptionsMenu(button) {
   var songId = $(button).prevAll(".songId").val();
   // console.log(songId);
   var menu = $(".optionsMenu");
   var menuWidth = menu.width();
   menu.find(".songId").val(songId);

   var scrollTop = $(window).scrollTop(); //Distance from top of window to top of document
   var elementOffset = $(button).offset().top; //Distance from top of document

   var top = elementOffset - scrollTop;
   var left = $(button).position().left - menuWidth;

   menu.css({ "top": top + "px", "left": left + "px", "display": "inline" });
   
}

function hideOptionsMenu() {
   var menu = $(".optionsMenu");
   if(menu.css("display") != "none") {
      menu.css("display", "none");
   }
}

function formatTime(seconds) {

   let time = Math.round(seconds);
   let minutes = Math.floor(time / 60); //Rounds down - 230/60 = 3.83 -> 3 minutes
   let sec = time - (minutes * 60);
   
   if(sec < 10) {
      sec = "0" + sec;
   }
   
   return minutes + ":" + sec;
}

function updateTimeProgressBar(audio) {

   let current = document.querySelector(".progressTime.current");
   let remaining = document.querySelector(".progressTime.remaining");

   current.textContent = formatTime(audio.currentTime);
   remaining.textContent = formatTime(audio.duration - audio.currentTime);
   
   //calculate percentage
   let progress = audio.currentTime / audio.duration * 100;
   document.querySelector(".playbackBar .progress").style.width = progress + '%';
}

function updateVolumeProgressBar(audio) {
   let volume = audio.volume * 100;
   document.querySelector(".volumeBar .progress").style.width = volume + "%";
}

function playFirstSong() {
   setTrack(tempPlaylist[0], tempPlaylist, true);
}

//audio class
function Audio() {

   this.audio = document.createElement('audio');
   this.currentlyPlaying;

   this.audio.onended = function() {
      nextSong();
   }

   this.audio.oncanplay = function() {
      let duration = formatTime(this.duration);

      if(this.currentTime == 0) {
         document.querySelector(".progressTime.remaining").textContent = duration;
      }
   }

   this.audio.ontimeupdate = function() {
      if(this.duration) {
         updateTimeProgressBar(this);
      }
   }

   this.audio.onvolumechange = function() {
      updateVolumeProgressBar(this);
   }

   //set a new song
   this.setSong = function(song) {
      this.currentlyPlaying = song;
      this.audio.src = song.path;
   }

   this.playAudio = function() {
      this.audio.play();
   }

   this.pauseAudio = function() {
      this.audio.pause();
   }

   this.setTime = function(seconds) {
      this.audio.currentTime = seconds;
   }
}