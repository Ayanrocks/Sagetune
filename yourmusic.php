<?php 

        include("includes/includedfiles.php");


?>

<div class="playlistcontainer">
    <div class="gridviewcontainer">
        <h2>Playlists</h2>
        <div class="buttonitems">
            <button class="button blue" onclick="createplaylist()">New Playlists</button>
        </div>

        <?php
        $username = $userLoggedIn->getusername();

                $playlistquery = mysqli_query($con, "SELECT * FROM playlists WHERE owner = '$username'");
        
                if(mysqli_num_rows($playlistquery) == 0 )
        {
            echo "<span class='noresults'>You don't have any playlist</span>";
        }       

        while($row = mysqli_fetch_array($playlistquery))
        {
            $playlist = new Playlist($con, $row);
            echo " <div class='gridviewitem' role='link' tabindex='0' onclick=openpage(\"playlist.php?id=".$playlist->getid()."\")>

            <div class='playlistimage'>
                <img src='https://png.icons8.com/100/ffffff/personal-video-recorder-menu.png'>
            </div>
            
            <div class='gridviewinfo'>"  
                    . $playlist->getname(). "
                  </div>
                </div>";
           
        }
         
         ?>




    </div>
</div>