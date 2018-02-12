<?php
include("../../config.php");

if(!isset($_POST['username']))
{
    echo "Error: Could not set username";
    exit();
}
   if(!isset($_POST['oldpassword']) || !isset($_POST['newpassword1']) || !isset($_POST['newpassword2']))
   {
       echo "Not all passwords are set";
       exit();
   }
   
   if($_POST['oldpassword'] == "" || $_POST['newpassword1'] == "" || $_POST['newpassword2'] == "")
   {
       echo "Please fill in all fields";
       exit();
   } 
$username  = $_POST['username'];
$oldpassword  = $_POST['oldpassword'];
$newpassword1  = $_POST['newpassword1'];
$newpassword2  = $_POST['newpassword2'];

$oldmd5 = md5($oldpassword);

$passwordcheck = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND password ='$oldmd5'");
if(mysqli_num_rows($passwordcheck) != 1)
{
    echo "Password is incorrect";
    exit();
}

if($newpassword1 != $newpassword2)
{
    echo "Passwords don't match";
    exit();
}

if(preg_match('/[^A_Za-z0-9]@#$/', $newpassword1))
{
    echo "Your password contain invalid characters. (Only @,#,$ are supported)";
    exit();
}

if(strlen($newpassword1 > 30 || strlen($newpassword1) < 6))
{
    echo "Your new password must be between 6 to 30 characters";
    exit();
}

$newmd5 = md5($newpassword1);
$query = mysqli_query($con, "UPDATE users SET password='$newmd5' WHERE username = '$username'");
echo "Password Updated Successfully";

?>
