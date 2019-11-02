<?php
include("includes/config.php");


if(isset($_SESSION['userLoggedIn'])) {
	$userLoggedIn = $_SESSION['userLoggedIn'];
}
else {
	header("Location: register.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Melodify</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>
<body>

	<div id="nowPlayingBarContainer">
		
		<div id="nowPlayingBar">
				
			<div id="nowPlayingLeft">
				<div class="content">
					<span class="albumLink">
						<img src="https://www.browntrout.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/9/7/9781465085481_CVR.jpg" class="albumArtwork">
					</span>

					<div class="trackDetails">
						<span class="songName">
							<span>Lose Yourself</span>
						</span>
						<span class="songAuthor">
							<span>Eminem</span>
						</span>
					</div>

				</div>
			</div>
			<div id="nowPlayingCenter">

				<div class="content playerControls">

					<div class="buttons">

						<button class="controlButton shuffle" alt="shuffle button" title="Shuffle button">
							<img src="assets/images/icons/shuffle.png">
						</button>

						<button class="controlButton previous" alt="previous button" title="Previous button">
							<img src="assets/images/icons/previous.png">
						</button>

						<button class="controlButton play" alt="play button" title="Play button"> 
							<img src="assets/images/icons/play.png">
						</button>

						<button class="controlButton pause" style="display: none;" alt="pause button" title="Pause button">
							<img src="assets/images/icons/pause.png">
						</button>

						<button class="controlButton next" alt="next button" title="Next button">
							<img src="assets/images/icons/next.png">
						</button>

						<button class="controlButton repeat" alt="repeat button" title="Repeat button">
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

					<button class="controlButton volume" title="Volume button" alt="volume button">
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

</body>
</html>