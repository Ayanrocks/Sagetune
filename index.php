<?php 

include("includes/includedfiles.php");

?>


  <h1 class="pageheadingbig">You Might Like This</h1>
          <div class="gridviewcontainer"></div>

          <?php  
            $albumquery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND() LIMIT 10");

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



  <!-- TODO 

 
    
  FIX REGISTER PHONE NUMBER VALIDATION  









 -->