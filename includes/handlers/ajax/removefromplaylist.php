<?php 

include("../../config.php");

if(isset($_POST['playlistid']) && isset($_POST['songid']))
    {
        $playlistid = $_POST['playlistid'];
        $songid = $_POST['songid'];
        $query = mysqli_query($con, "DELETE FROM playlistsongs WHERE playlistsid='$playlistid' AND songid='$songid'");
        
    }

    else {
        echo "Playlist id or songid  not passed from remove file";
    }


?>