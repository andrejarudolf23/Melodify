<div id="navBarContainer">
   <nav class="navBar">
      <span role="link" tabindex="0" onclick="openPage('index.php')" class="logo">
         <img src="assets/images/icons/logo2.png">
      </span>
      <div class="group">
         <div class="navItem">
            <span role='link' tabindex='0' onclick='openPage("search.php")' class="navLink">
               Search
               <img src="assets/images/icons/search.png" class="searchIcon">
            </span>
         </div>
      </div>
      <div class="group">
         <div class="navItem">
            <span role="link" tabindex="0" onclick="openPage('browse.php')" class="navLink">Browse</span>
         </div>
         <div class="navItem">
            <span role="link" tabindex="0" onclick="openPage('yourMusic.php')" class="navLink">Your music</span>
         </div>
         <div class="navItem">
            <span role="link" tabindex="0" onclick="openPage('settings.php')" class="navLink"><?php echo $userLoggedIn->getFirstAndLastName(); ?></span>
         </div>
      </div>
   </nav>
</div>