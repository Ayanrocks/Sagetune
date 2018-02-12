<?php

include("../../config.php");

if(isset($_POST['songid']))
{
    $songid = $_POST['songid'];
    $query = mysqli_query($con, "UPDATE songs SET plays = plays + 1 WHERE id = '$songid'");
   

}

?>