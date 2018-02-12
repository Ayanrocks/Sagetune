<?php

    class Song {

        private $con;
        private $id;
        private $mysqlidata;
        private $title;
        private $artistid;
        private $albumid;
        private $duration;
        private $path;
        private $genre;
         
        public function __construct($con, $id) {
            $this->con = $con;
            $this->id = $id;

            $query = mysqli_query($this->con , "SELECT * FROM songs WHERE id='$this->id'");
            $this->mysqlidata = mysqli_fetch_array($query);

            $this->title = $this->mysqlidata['title'];
            $this->artistid = $this->mysqlidata['artist'];
            $this->albumid = $this->mysqlidata['album'];
            $this->genre = $this->mysqlidata['genre'];
            $this->duration = $this->mysqlidata['duration'];
            $this->path = $this->mysqlidata['path'];

        }

        public function getid() {
            return $this->id;
        }

        public function gettitle() {
            return $this->title;
        }
         
        public function getartist() {
            return new Artist($this->con, $this->artistid);
        } 
        public function getalbum() {
            return new Album($this->con, $this->albumid);
        } 
        
        public function getpath() {
            return $this->path;
        } 
        
        public function getduration() {
            return $this->duration;
        } 
        public function getmysqlidata() {
            return $this->mysqlidata;
        }
         public function getgenre() {
            return $this->genre;
        }

    
    }

?>