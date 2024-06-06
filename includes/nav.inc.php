<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  $loggedin = true;
} else {
  $loggedin = false;
}



if (!$loggedin) {
  echo '
        <a href="instraction.php">Instruction</a>
        <a href="contact.php">Contact</a>
        <a href="loggin.php" color = "red"><button type="button" class="btn btn-info">Login</button></a>
        <a href="signup.php" color = "red"><button type="button" class="btn btn-info">SignUp</button></a>
        <a href="./admin/adminidx.php" color = "red"><button type="button" class="btn btn-warning">Admin</button></a>
        <a href="./auth/adminidx.php" color = "red"><button type="button" class="btn btn-warning">Authority</button></a>
        <a href="./approver/adminidx.php" color = "red"><button type="button" class="btn btn-warning">Approver</button></a>
              ';
}

if ($loggedin) {
  echo '<a href="index.php">Home</a>
  <div class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Application
  </a>
  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
    <a class="dropdown-item" href="application.php">Apply for a New Passport</a>
    <a class="dropdown-item" href="checkappstatus.php">Check Staus</a>
    <a class="dropdown-item" href="makepayment.php">Make Payment</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="renew.p.php?id='.$_SESSION['username'].'">Renew</a>
    <a class="dropdown-item" href="showpassport.php?id='.$_SESSION['username'].'">showpassport</a>
  </div>
</div>
        <a href="instraction.php">Instruction</a>
      <a href="contact.php">Contact</a>
      ';
  echo '<a href="logout.php" color = "red"><button type="button" class="btn btn-danger">Log Out</button></a>';
}



?>