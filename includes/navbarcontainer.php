<div id="navbarcontainer">
    <nav class="navbar">
        <span role="link" tabindex="0" onclick="openpage('index.php')" class="logo" >
            <img src="assets/images/logo/music.png" alt="Sagetune">
        </span>
        <div class="group">
            <div class="navitem">
               <span role="link" tabindex="0" onclick="openpage('search.php')" class="navitemlink">Search
                    <div class="icon" title="Search">

                    </div>
                </span>
            </div>
        </div>
        <div class="group">
            <div class="navitem">
<span role="link" tabindex="0" onclick="openpage('browse.php')" class="navitemlink">Browse</span>
            </div>
            <div class="navitem">
                <span role="link" tabindex="0" onclick="openpage('yourmusic.php')"  class="navitemlink">Your Music</span>
            </div>
            <div class="navitem">
                <span role="link" tabindex="0" onclick="openpage('settings.php')"  class="navitemlink"><?php echo $userLoggedIn->getname(); ?></span>
            </div>
        </div>





    </nav>
</div>