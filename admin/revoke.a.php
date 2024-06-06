<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: loggin.php");
    exit;
}
if ($_SESSION['usertype'] != 'admin') {
    header("location: loggin.php");
  
    exit;
  }
include "includes/db.inc.php";
$haveResult = false;

$sql = "SELECT * FROM revokeapplication WHERE status != 'approved' and status != 'rejected'";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
    $haveResult = true;
} else {
    $haveResult = false;
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
                
                    <?php
                    if ($haveResult) {
                        echo '
                        <table class="table">
                        <thead>
                            <tr>
                                <th>Application ID</th>
                                <th>Passport NO</th>
                                <th>Status</th>
                                
                                
                            </tr>
                        </thead>
                        <tbody>';

                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>
                                    <td>' .$row['revokeID'].'</td>
                                    <td>'. $row['PassportID'].'</td>
                                    <td>'. $row['status'].'</td>
                                    ';
                                    
                                    echo"
                                    <td><a class ='btn btn-primary btn-sm' href=revoke.e.php?id=$row[PassportID]>edit</a> </td>
                                    </tr>";
                        }
                    }
                    ?>
                    </tbody>
                    </table>
                    <!--<a href="#"><button type="button" class="btn btn-primary">Check Passport Validity</button></a>
          <a href="#"><button type="button" class="mx-2 btn btn-primary">Revokation Application</button></a>-->
                
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