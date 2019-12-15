<?php
   class Artist {

      private $id;
      private $con;

      public function __construct($con, $id) {
         $this->id = $id;
         $this->con = $con;
      }

      public function getId() {
         return $this->id;
      }

      public function getName() {
         $nameQuery = mysqli_query($this->con, "SELECT name FROM artists WHERE id='$this->id'");
         $artist = mysqli_fetch_array($nameQuery);

         return $artist['name'];
      }

      public function getSongsIds() {
         $query = mysqli_query($this->con, "SELECT id FROM songs WHERE artist='$this->id' ORDER BY plays");
         $returnArray = array();

         while($row = mysqli_fetch_array($query)) {
            array_push($returnArray, $row['id']);
         }

         return $returnArray;
      }

   }

?>