<?php
   class Song {

      private $id;
      private $con;
      private $title;
      private $artistId;
      private $albumId;
      private $genreId;
      private $duration;
      private $songData;

      public function __construct($con, $id) {
         $this->con = $con;
         $this->id = $id;

         $query = mysqli_query($this->con, "SELECT * FROM songs WHERE id='$this->id'");
         $this->songData = mysqli_fetch_array($query);
         $this->title = $this->songData['title'];
         $this->artistId = $this->songData['artist'];
         $this->albumId = $this->songData['album'];
         $this->genreId = $this->songData['genre'];
         $this->duration = $this->songData['duration'];
         $this->path = $this->songData['path'];
      }

      public function getId() {
         return $this->id;
      }

      public function getTitle() {
         return $this->title;
      }

      public function getArtist() {
         return new Artist($this->con, $this->artistId);
      }

      public function getAlbum() {
         return new Album($this->con, $this->albumId);
      }

      public function getGenre() {
         return $this->genreId;
      }

      public function getDuration() {
         return $this->duration;
      }

      public function getPath() {
         return $this->path;
      }
      
   }
?>