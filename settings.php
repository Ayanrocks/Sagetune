<?php
    include("includes/includedfiles.php");


?>

    <div class="entityinfo">
        <div class="centersection">
            <div class="userinfo">
                <h1>
                    <?php echo $userLoggedIn->getname(); ?>
                </h1>
            </div>
        </div>

        <div class="buttonitems">
            <button class="button" onclick="openpage('updatedetails.php')">User Details</button>
            <button class="button" onclick="logout()">Logout</button>
        </div>

    </div>