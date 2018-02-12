<?php 
    include("includes/includedfiles.php");

    if(isset($_GET['id']))
 {
     $artistid = $_GET['id'];
      }
 else 
 {
     header("Location: index.php");
 }

 $artist = new Artist($con, $artistid);


?>

<div class="entityinfo borderbottom">
    <div class="centersection">
        <div class="artistinfo">
            <h1 class="artistname">
                <?php echo $artist->getname(); ?>
            </h1>
            <div class="headerbuttons">
                <button class="button blue" onclick="playfirstsong()">Play
                </button>
            </div>
        </div>
    </div>
</div>

<div class="tracklistcontainer borderbottom">
    <h2>Songs</h2>
    <ul class="tracklist">

        <?php

          $songidarray = $artist->getsongid();
          $i = 1;
          foreach ($songidarray as $songid )
          {
              if($i > 5)
              {
                  break;
              }
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

<div class="gridviewcontainer">
    <h2>Albums</h2>

    <?php  
            $albumquery = mysqli_query($con, "SELECT * FROM albums WHERE artist = '$artistid'");

            while($row = mysqli_fetch_array($albumquery))
            {



              echo "<div class='gridviewitem'> 
              <span role='link' tabindex='0' onclick='openpage(\"album.php?id=". $row['id'] ."\")'>
                  <img src='". $row['artworkpath'] ." '>

                  <div class='gridviewinfo'>"  
                    . $row['title'] . "
                  </div>
                  </span>

                </div>
              
              ";


            }

          ?>
</div>

<nav class="optionsmenu">
    <input type="hidden" class="songid">
    <?php echo Playlist::getplaylistoption($con, $userLoggedIn->getusername()); ?>
</nav>