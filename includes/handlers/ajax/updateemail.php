<?php
include("../../config.php");

if(!isset($_POST['username']))
{
    echo "Error: Could not set username";
    exit();
}
    if(isset($_POST['email']) && $_POST['email'] != "")
    {
$username  = $_POST['username'];
$email  = $_POST['email'];

if(!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    echo "Email is invalid";
    exit();
}

$emailcheck = mysqli_query($con, "SELECT email FROM  users WHERE email='$email' AND username !='$username'");
if(mysqli_num_rows($emailcheck) > 0)
{
    echo "Email already in use";
    exit();
} 

$updatequery = mysqli_query($con, "UPDATE users SET email = '$email' WHERE username='$username'");
echo "Update Successful";


    }
    else {
        echo "you must give email";
    }
    
?>
