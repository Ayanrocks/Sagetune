<?php

    include("includes/includedfiles.php");

    if(isset($_GET['term']))
    {
        $term = urldecode($_GET['term']);

    }
    else 
    {
        $term = "";

    }


?>

    <div class="searchcontainer">
        <h4>Search for an artist, album or songs</h4>
        <input onfocus="this.value = this.value" type="text" class="searchinput" value="<?php echo $term; ?>" placeholder="Start Typing..." >
    </div>

    <script>
         $("input.searchinput").focus();

        $(function () {
            
            $(".searchinput").keyup(function () {
                clearTimeout(timer);
                timer = setTimeout(function () {
                    var val = $(".searchinput").val();
                    openpage("search.php?term=" + val);
                }, 1000);
            });
        });
    </script>

    <?php if($term == "") exit() ?>


    <div class="tracklistcontainer borderbottom">
        <h2>Songs</h2>
        <ul class="tracklist">

            <?php

        $songsquery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10");

        if(mysqli_num_rows($songsquery) == 0 )
        {
            echo "<span class='noresults'> No Songs found matching ". $term . "</span>";
        }

        $songidarray = array();
          $i = 1;
          while($row = mysqli_fetch_array($songsquery))
            {
              if($i > 15)
              {
                  break;
              }

              array_push( $songidarray, $row['id']);

              $albumsong = new Song($con, $row['id']);
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

    <div class="artistcontainer borderbottom">
        <h2>Artists</h2>
        <?php

                $artistquery = mysqli_query($con, "SELECT id FROM artist WHERE name LIKE '$term%' LIMIT 10");
        
                if(mysqli_num_rows($artistquery) == 0 )
        {
            echo "<span class='noresults'> No Artists found matching ". $term . "</span>";
        }       

        while($row = mysqli_fetch_array($artistquery))
        {
            $artistfound = new Artist($con, $row['id']);

            echo "<div class='searchresultrow'>
                    <div class='artistname'>
                        <span role='link' tabindex='0' onclick='openpage(\"artist.php?id=" . $artistfound->getid() . "\")' >
                        "
                            .$artistfound->getname().
                        "
                        </span>
                    </div>
            
                  </div>";
        }
         
         ?>
    </div>
    </div>



    <div class="gridviewcontainer">
        <h2>Albums</h2>

        <?php  
            $albumquery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '$term%' LIMIT 5");


            if(mysqli_num_rows($albumquery) == 0 )
        {
            echo "<span class='noresults'> No Albums found matching ". $term . "</span>";
        }

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