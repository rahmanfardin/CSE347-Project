<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: loggin.php");
    exit;
}

include "includes/db.inc.php";
$haveResult = false;
include 'includes/db.inc.php'; // Assuming this file contains your connection logic

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $u = mysqli_real_escape_string($conn, $_GET['id']); // Prevent SQL injection
    
    // Improved SQL query (handle case sensitivity and typos)
    $sql = "SELECT * FROM passport NATURAL JOIN passportvalidity WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $u);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt); // Get the result object

        if ($result && mysqli_num_rows($result) > 0) { // Check if there are results
            $row = mysqli_fetch_assoc($result);
            $appid = $row['PassportID'];
            $username = $row['username'];
            $fname = $row['fname'];
            $lname = $row['lname'];
            $fathername = $row['fathername'];
            $mothername = $row['mothername'];
            $email = $row['email'];
            $phone = $row['phone'];
            $nid = $row['nid'];
            $address = $row['address'];
            $dob = $row['DOB'];
            $dod = $row['DOD'];
            $doe = $row['DOE'];
            $isRovoked = $row['isRevoked'];
            $isValid = $row['isValid'];
            $haveResult = true;
        }
        mysqli_stmt_close($stmt); // Close the prepared statement
    } else {
        // Handle the case where the query preparation fails
        echo "Error preparing the statement: " . mysqli_error($conn);
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

    <link href="styles.css" rel="stylesheet" type="text/css" />


    <title>Welcome - <?php echo $_SESSION['username'] ?></title>
</head>

<body>
    <header>
        <div class="container">
            <?php require 'includes/header.inc.php' ?>
            <hr style="color: black;">
            <div class="body-tag">
            <h1 class="text-center" style="color:green;">Passport Renewal<br/></h1><br/>

                <?php if ($haveResult) {
                    echo '
                <table class="table mx -5">
                    <tbody>
                        <tr>
                            <td>Passport Number:</td>
                            <td> ' . $appid . '</td>
                        </tr>

                        <tr>
                            <td>First Name:</td>
                            <td>' . $fname . '</td>
                        </tr>
                        <tr>
                            <td>Last Name:</td>
                            <td>' . $lname . '</td>
                        </tr>
                        <tr>
                            <td>Date of Birth:</td>
                            <td>' . $dob . '</td>
                        </tr>
                        <tr>
                            <td>Fahters Name:</td>
                            <td>' . $fathername . '</td>
                        </tr>
                        <tr>
                            <td>Mothers Name:</td>
                            <td>' . $mothername . '</td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>' . $email . '</td>
                        </tr>
                        <tr>
                            <td>Phone Number:</td>
                            <td>' . $phone . '</td>
                        </tr>
                        <tr>
                            <td>NID:</td>
                            <td>' . $nid . '</td>
                        </tr>
                        <tr>
                            <td>Date of Delivary:</td>
                            <td>' . $dod . '</td>
                        </tr>
                        <tr>
                            <td>Date of Expiry:</td>
                            <td>' . $doe . '</td>
                        </tr>
                        <tr>
                            <td>Passport Revoked</td>
                            <td>' . $isRovoked . '</td>
                        </tr>
                        <tr>
                            <td>Passport Valid</td>
                            <td>' . $isValid . '</td>
                        </tr>
                    </tbody>
                </table>
                <a href='.'"check.r.php?id='.$appid.'"><button type="button" class="btn btn-danger">Renew</button></a>
          <a href="index.php"><button type="button" class="mx-2 btn btn-primary">GoBack</button></a>
';
                } else {
                    echo '
    <h5>You dont have any passport. <a href = "application.php">APPLY</a> for one</h5>
    ';
                } ?>
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