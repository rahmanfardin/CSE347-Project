<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: loggin.php");
    exit;
}
$showAlert = false;
$showError = false;
include 'includes/db.inc.php';
include 'includes/application.inc.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_SESSION["username"];
    $fname = $conn->real_escape_string($_POST["fname"]);
    $lname = $conn->real_escape_string($_POST["lname"]);
    $fathername = $conn->real_escape_string($_POST["fathername"]);
    $mothername = $conn->real_escape_string($_POST["mothername"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $phone = $conn->real_escape_string($_POST["phone"]);
    $nid = $conn->real_escape_string($_POST["nid"]);
    $address = $conn->real_escape_string($_POST["address"]);

    $dob = $conn->real_escape_string($_POST["dob"]);
    $printStatus = "not";
    $status = "pay";





    $checkAllFields = allFieldsEntered($fname, $lname, $fathername, $mothername, $email, $phone, $nid, $address, $dob);
    $checkIfApplicationExists = checkIfApplicationExists($username, $conn);
    $checkPassportExists = checkIfPassportExists($username, $conn);
    if ($checkAllFields) {
        if (!$checkIfApplicationExists) {
            if (!$checkPassportExists) {
                $sql = "INSERT INTO `application` ( username, fname, lname, fathername, mothername, DOB, email, phone, nid, address, status, printStatus) VALUES ('$username', '$fname', '$lname', '$fathername', '$mothername', '$dob', '$email', '$phone', '$nid', '$address', '$status', '$printStatus');";

                $result = mysqli_query($conn, $sql);
                $showAlert = $showAlert . ' ' . $dob;
                if (!validateDate($dob)) {
                    $showError = $showError . "Invalid date of birth format. Please use YYYY-MM-DD.";
                }
            } else {
                $showError = $showError . "user allready has a passport";
            }
        } else {
            $showError = $showError . "user allready has a application try resubmitting!!";
        }
    } else {
        $showError = $showError . "Enter all fields correctly!!";
    }


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


    <title>Application</title>
</head>

<body>
    <header>
        <div class="container">
            <?php require 'includes/header.inc.php' ?>
            <hr style="color: black;">
            <?php
            if ($showAlert) {
                echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Your application was successful submitted
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div> ';
            }
            if ($showError) {
                echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> ' . $showError . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
            }
            ?>
            <div class="body-tag">


                <div class="container my+4">
                    <?php


                    $username = $_SESSION['username'];
                    $checkIfAppExists = checkIfApplicationExists($username, $conn);
                    if (!$checkIfAppExists) {
                        echo '
                    <h1 class="text-center" style="color:green;">Welcome to the Application Page
                        <br>-' . $_SESSION['username'] . '
                    </h1>
                    <form action="application.php" method="post" class="starlabel">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="fname" style="color:green;">First Name</label>
                                <input type="text" class="form-control" id="fname" name="fname" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lname" style="color:green;">Last Name</label>
                                <input type="text" class="form-control" id="lname" name="lname" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fathername" style="color:green;">Father\'s Name</label>
                            <input type="text" class="form-control" id="fathername" name="fathername">
                        </div>
                        <div class="form-group">
                            <label for="mothername" style="color:green;">Mother\'s Name</label>
                            <input type="text" class="form-control" id="mothername" name="mothername">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="dob" style="color:green;">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nid" style="color:green;">NID</label>
                                <input type="text" class="form-control" id="nid" name="nid">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email" style="color:green;">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    aria-describedby="emailHelp" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone" style="color:green;">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="address" style="color:green;">Address</label>
                            <textarea class="form-control" id="address" name="address"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary my-4">SignUp</button>
                    </form>';
                    } else {
                        echo '<h1 class="text-center" style="color:green;">You already have an application
                        <br>- go to <a href="checkappstatus.php"> check status</a>
                    </h1>';
                    }
                    ?>
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