<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  $loggedin = true;
} else {
  $loggedin = false;
}



      if(!$loggedin){
        echo '
        
        <a href="../index.php" color = "red"><button type="button" class="btn btn-warning">USER</button></a>
        
        
              
              ';
      }
      if ($loggedin) {
        echo '<a href="adminidx.php">Home</a>
        
      <a href="contact.php">Contact</a>';
      echo '<a href="logout.php" color = "red"><button type="button" class="btn btn-danger">Log Out</button></a>';
      }



?>