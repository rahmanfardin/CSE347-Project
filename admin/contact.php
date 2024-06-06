<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $loggedin = true;
} else {
    $loggedin = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>contact | Fardin Rahman</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400..700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<body>

<header>
        <div class="container">
            <?php require 'includes/header.inc.php' ?>
            <hr style="color: black;">

            <div class="body-tag">
                <div class="row justify-content-center"> <div class="col-md-5 mx-5 my-5 text-center"> 
                        <h3>Admin Information</h3>
                        <hr />
                        <address>
                            Developed by <a href="mailto:mohammadfardinrahman@gmail.com">Group 7</a>.<br>
                            Visit us at:<br>
                            <a href="https://www.fardin.com.bd/project">www.fardin.com.bd/project</a><br>
                            Aftabnogor<br>
                            Dhaka
                        </address>
                    </div>
                    
                
                    <div class="col-md-5 mx-5 my-5 text-center"> 
                        <h3>Passport Office Information</h3>
                        <hr />
                        <address>
                            Department of Immigration and Passport<br>
                            7-E Agargaon<br>
                            Shere-E-Bangla Nagor<br>
                            Dhaka-1207, Bangladesh<br>
                            Email Address:<a href="mailto:inquiry@passport.gov.bd">inquiry@passport.gov.bd</a>
                        </address>
                    </div>
                </div> 
            </div>
        </div>
    </header>
</body>

</html>