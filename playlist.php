 <?php include("includes/includedfiles.php"); 
 
 if(isset($_GET['id']))
 {
     $playlistid = $_GET['id'];
      }
 else 
 {
     header("Location: index.php");
 }

$playlist = new Playlist($con, $playlistid);
$owner = new User($con, $playlist->getowner())
?>


 <div class="entityinfo">
     <div class="leftsection">
     <div class="playlistimage">
        <img src="https://png.icons8.com/100/ffffff/personal-video-recorder-menu.png" alt="playlist">
        </div>
     </div>

     <div class="rightsection">
        <h2><?php echo $playlist->getname(); ?></h2>
        <p>By <?php echo $playlist->getowner(); ?> </p>
        <p><?php echo $playlist->getnosongs(); 
        if($playlist->getnosongs() > 1) 
        {echo " Songs ";} 
        else {echo " Song";} ?> </p>
         <button class="button" onclick="deleteplaylist(' <?php echo $playlistid ; ?>')">Delete Playlist</button>
        
     </div>
 </div>

 <div class="tracklistcontainer">
     <ul class="tracklist">

        <?php

          $songidarray =  $playlist->getsongid();
          $i = 1;
          foreach ($songidarray as $songid )
          {
              $playlistsong = new Song($con, $songid);
              $songartist = $playlistsong->getartist();
              echo "<li class='tracklistrow'>
                <div class='trackcount'>
                <img class='play' src='https://png.icons8.com/android/50/ffffff/play.png' onclick='settrack(\"". $playlistsong->getid() ."\", tempplaylist, true)'>
                    <span class='tracknumber'>$i</span>
                </div>
                <div class='trackinfo'>

                <span class='trackname'> " . $playlistsong->gettitle() . "
                </span>
                <span class='artistname'>". $songartist->getname() . "</span>

                </div>

                <div class='trackoptions'>
                    <input type='hidden' class='songid' value='".$playlistsong->getid()."'>
                    <img class='optionbutton' src='https://png.icons8.com/android/50/1566c2/more.png' onclick='showoptionmenu(this)'>

                </div>

                <div class='trackduration'>
                    <span class='duration'>" .$playlistsong->getduration()."</span>
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
    <div class="item" onclick='removefromplaylist(this, <?php echo $playlistid ?>)'>Remove from Playlist</div>
</nav>

 





