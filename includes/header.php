<?php

    include("includes/config.php");
    include("includes/classes/User.php");
    include("includes/classes/Artist.php");
    include("includes/classes/Album.php");
    include("includes/classes/Song.php");
    include("includes/classes/Playlist.php");



  if(isset($_SESSION['userLoggedIn']))
  {
   
    $userLoggedIn=new User($con, $_SESSION['userLoggedIn']);
    $username = $userLoggedIn->getusername();
    echo "<script>userloggedin = '$username';</script>";
  }
  else {
    header("Location: register.php");
  }


 ?>



  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <title>Welcome to Sagetune</title>
    <link rel="shortcut icon" href="assets/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="icon" href="assets/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="assets/js/script.js "></script>
  </head>

  <body oncontextmenu="return false;">



    <div id="maincontainer">

      <div id="topcontainer">
        <?php include("includes/navbarcontainer.php"); ?>
        <div id="mainviewcontainer">
          <div id="maincontent">