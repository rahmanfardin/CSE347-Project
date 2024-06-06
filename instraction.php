<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $loggedin = true;
} else {
    $loggedin = false;
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400..700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="styles.css" />


    <title>Instractions</title>
</head>

<body>
    <header>
        <div class="container">
            <?php require 'includes/header.inc.php' ?>
            <hr style="color: black;">
            <div class="body-tag">
            <h1 class="text-center" style="color:green;">STEP BY STEP APPLICATION PROCESS</h1>

                <div class="step">
                    <span class="step-number">1.</span> you need to
                    <?php if (!$loggedin) {
                        echo '<a href = "signup.php">sign up</a>';
                    } else {
                        echo 'sign up';
                    } ?> or
                    <?php if (!$loggedin) {
                        echo '<a href = "loggin.php">loggin</a>.';
                    } else {
                        echo 'loggin.';
                    } ?>
                </div>
                <div class="step">
                    <span class="step-number">2.</span> you need to file an
                    <?php if (!$loggedin) {
                        echo 'application.';
                    } else {
                        echo '<a href = "application.php">application</a>.';
                    } ?> 
                    
                </div>
                <div class="step">
                    <span class="step-number">3.</span> Check for <?php if (!$loggedin) {
                        echo 'Application Status';
                    } else {
                        echo '<a href="checkappstatus.php">Application Status</a>.';
                    } ?> 
                </div>

                <div class="step">
                    <span class="step-number">4.</span><?php if (!$loggedin) {
                        echo 'Pay';
                    } else {
                        echo '<a href = "makepayment.php">Pay</a>';
                    } ?>  the fee.
                </div>

                <div class="step">
                    <span class="step-number">5.</span> Check <?php if (!$loggedin) {
                        echo 'Passport Status.';
                    } else {
                        echo '<a href = "checkappstatus.php">Passport Status</a>.';
                    } ?> </div>

                <div class="step">
                    <span class="step-number">6.</span> Disapproved candidates have to apply again.
                </div>

            </div>

        </div>



    </header>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
</body>

</html>