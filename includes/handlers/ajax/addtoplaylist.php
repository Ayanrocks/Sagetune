<?php
include("../../config.php");

if(isset($_POST['playlistid']) && isset($_POST['songid']))
    {
        $playlistid = $_POST['playlistid'];
        $songid = $_POST['songid'];
        $orderquery = mysqli_query($con, "SELECT playlistorder FROM playlistsongs WHERE playlistsid='$playlistid' ORDER BY playlistorder DESC LIMIT 1");
        $row = mysqli_fetch_array($orderquery);
        $order = $row['playlistorder'] + 1;

        $query = mysqli_query($con, "INSERT INTO playlistsongs VALUES ('', '$songid', '$playlistid', '$order')");
        
    }

    else {
        echo "Playlist id or songid not passed";
    }
?>