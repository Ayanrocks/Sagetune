<?php

    class Album {

        private $con;
        private $id;
        private $title;
        private $artistid;
        private $genre;
        private $artworkpath;

        
        public function __construct($con, $id) {
            $this->con = $con;
            $this->id = $id;

            $query = mysqli_query($this->con , "SELECT * FROM albums WHERE id='$this->id'");
            $album = mysqli_fetch_array($query);

            $this->title = $album['title'];
            $this->artistid = $album['artist'];
            $this->genre = $album['genre'];
            $this->artworkpath = $album['artworkpath'];
        }

        public function gettitle() {
            return $this->title;
        }
        public function getartist() {
            return new Artist($this->con, $this->artistid);
        }
        public function getgenre() {
            return $this->genre;
        }
        public function getartwork() {
            return $this->artworkpath;
        }

        public function getnosongs() {
            $query = mysqli_query($this->con, "SELECT id FROM songs WHERE album ='$this->id' ");
            return mysqli_num_rows($query);
        }

        public function getsongid()
        {
            $query = mysqli_query($this->con, "SELECT id FROM songs WHERE  album = '$this->id' ORDER BY albumorder ASC ");

            $array = array();
            while ($row = mysqli_fetch_array($query))
            {
                array_push($array, $row['id']);
            }

            return $array;
        }
    }

?>