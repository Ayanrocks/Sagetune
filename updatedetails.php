<?php 
include("includes/includedfiles.php");
?>

<div class="userdetails">
    <div class="container borderbottom">
        <h2>Email</h2>
        <input type="text" name="email" class="email" placeholder="Enter new Email" value="<?php echo $userLoggedIn->getemail(); ?>">
    <span class="message"></span>
    <button class="button" onclick="updateemail('email')">Save</button>
    </div>
    <div class="container">
    <h2>Password</h2>
    <input type="password" name="oldpassword" class="oldpassword" placeholder="Enter Current Password">
    <input type="password" name="newpassword1" class="newpassword1" placeholder="Enter New Password">
    <input type="password" name="newpassword2" class="newpassword2" placeholder="Confirm Password">
    <span class="message"></span>
    <button class="button" onclick="updatepassword('oldpassword', 'newpassword1', 'newpassword2')">Save</button>

    </div>

</div>