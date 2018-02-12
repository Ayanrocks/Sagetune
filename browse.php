<?php 

include("includes/includedfiles.php");

?>


  <h1 class="pageheadingbig">Browse Our Collection</h1>
          <div class="gridviewcontainer">

          <?php  
            $albumquery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND()");

            while($row = mysqli_fetch_array($albumquery))
            {



              echo "<div class='gridviewitem'> 
              <span role='link' tabindex='0' onclick='openpage(\"album.php?id=". $row['id'] ."\")'>
                  <img src='". $row['artworkpath'] ." '>

                  <div class='gridviewinfo'>"  
                    . $row['title'] . "
                  </div>
                  </span>

                </div>
              
              ";


            }

          ?>
</div>


  <!-- TODO 

 
    
  FIX REGISTER PHONE NUMBER VALIDATION  









 -->