<?php 
    include("../../config.php");

    if(isset($_POST['playlistid']))
    {
        $playlistid = $_POST['playlistid'];
        $playlistquery = mysqli_query($con, "DELETE FROM playlists WHERE id='$playlistid'");
        $songquery = mysqli_query($con, "DELETE FROM playlistsongs WHERE playlistsid='$playlistid'");
    }

    else {
        echo "Playlist id not passed";
    }

?>