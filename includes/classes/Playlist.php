<?php
   class Playlist {

      private $con;
      private $id;
      private $playlistData;
      private $name;
      private $owner;      

      public function __construct($con, $id) {
         $this->con = $con;
         $this->id = $id;

         $query = mysqli_query($this->con, "SELECT * FROM playlists WHERE id='$this->id'");
         $this->playlistData = mysqli_fetch_array($query);
         $this->name = $this->playlistData['name'];
         $this->owner = $this->playlistData['owner'];
      }

      public function getId() {
         return $this->id;
      }

      public function getName() {
         return $this->name;
      }

      public function getOwner() {
         return $this->owner;
      }

      public function getNumberOfSongs() {
         $query = mysqli_query($this->con, "SELECT songId from playlistsongs WHERE playlistId='$this->id'");
         return mysqli_num_rows($query);
      }

      public function getSongsIds() {
         $query = mysqli_query($this->con, "SELECT songId from playlistsongs WHERE playlistId='$this->id' ORDER BY playlistOrder ASC");
         $returnArray = array();

         while($row = mysqli_fetch_array($query)) {
            array_push($returnArray, $row['songId']);
         }

         return $returnArray;
      }

      public static function getPlaylistsDropdown($con, $username) {
         
         $dropdown = '<select class="item playlist">
                        <option value="">Add to playlist</option>';
         
         $query = mysqli_query($con, "SELECT * FROM playlists WHERE owner='$username'");
         
         while($row = mysqli_fetch_array($query)) {
            $id = $row['id'];
            $name = $row['name'];

            $dropdown .= "<option value='$id'>$name</option>";
         }

         $dropdown .= '</select>';
         return $dropdown;
      }

   }
?>