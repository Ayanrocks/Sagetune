<?php include("includes/includedfiles.php"); 
 
 if(isset($_GET['id']))
 {
     $albumid = $_GET['id'];
      }
 else 
 {
     header("Location: index.php");
 }

$album = new Album($con , $albumid);
$artist = $album->getartist();
?>


<div class="entityinfo">
    <div class="leftsection">
        <img src="<?php echo $album->getartwork(); ?> " alt="">
    </div>

    <div class="rightsection">
        <h2>
            <?php echo $album->gettitle(); ?>
        </h2>
        <p>By
            <?php echo $artist->getname(); ?> </p>
        <p>
            <?php echo $album->getnosongs(); if($album->getnosongs() > 1) 
        {echo " Songs ";} 
        else {echo " Song";} ?> </p>

    </div>
</div>

<div class="tracklistcontainer">
    <ul class="tracklist">

        <?php

          $songidarray = $album->getsongid();
          $i = 1;
          foreach ($songidarray as $songid )
          {
              $albumsong = new Song($con, $songid);
              $albumartist = $albumsong->getartist();
              echo "<li class='tracklistrow'>
                <div class='trackcount'>
                <img class='play' src='https://png.icons8.com/android/50/ffffff/play.png' onclick='settrack(\"". $albumsong->getid() ."\", tempplaylist, true)'>
                    <span class='tracknumber'>$i</span>
                </div>
                <div class='trackinfo'>

                <span class='trackname'> " . $albumsong->gettitle() . "
                </span>
                <span class='artistname'>". $albumartist->getname() . "</span>

                </div>

                <div class='trackoptions'>
                    <input type='hidden' class='songid' value='".$albumsong->getid()."'>
                    <img class='optionbutton' src='https://png.icons8.com/android/50/1566c2/more.png' onclick='showoptionmenu(this)'>

                </div>

                <div class='trackduration'>
                    <span class='duration'>" .$albumsong->getduration()."</span>
                </div>

              </li>";

              $i++;
          }

          ?>
            <script>
                var tempsongid = '<?php echo json_encode($songidarray); ?>';
                tempplaylist = JSON.parse(tempsongid);
            </script>


    </ul>
</div>


<nav class="optionsmenu">
    <input type="hidden" class="songid">
    <?php echo Playlist::getplaylistoption($con, $userLoggedIn->getusername()); ?>
</nav>