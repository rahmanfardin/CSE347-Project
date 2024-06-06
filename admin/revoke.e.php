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
$hasResult = false;
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $appid = $_GET['id'];
    #echo $appid;
    include 'includes/db.inc.php';
    $sql = "SELECT * FROM passport NATURAL JOIN revokeapplication WHERE  PassportID=$appid";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    

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


    <title>Welcome - <?php echo $_SESSION['username'] ?></title>
</head>

<body>
    <header>
        <div class ="container">
            <?php require 'includes/header.inc.php' ?>
            <hr style="color: black;">
            <div class="body-tag">
               


            <h1 class="text-center" style="color:green;">Passport Information <br> of: <?php echo $fname .' ' . $lname;?></h1>
            <div class="my-5">
<table class="table mx -5">
<tbody>
    <tr>
        <td>Passport Number:</td>
        <td><?php echo $appid; ?></td>
    </tr>

    <tr>
        <td>First Name:</td>
        <td><?php echo $fname; ?></td>
    </tr>
    <tr>
        <td>Last Name:</td>
        <td><?php echo $lname; ?></td>
    </tr>
    <tr>
        <td>Date of Birth:</td>
        <td><?php echo $dob; ?></td>
    </tr>
    <tr>
        <td>Fahter's Name:</td>
        <td><?php echo $fathername; ?></td>
    </tr>
    <tr>
        <td>Mother's Name:</td>
        <td><?php echo $mothername; ?></td>
    </tr>
    <tr>
        <td>Email:</td>
        <td><?php echo $email; ?></td>
    </tr>
    <tr>
        <td>Phone Number:</td>
        <td><?php echo $phone; ?></td>
    </tr>
    <tr>
        <td>NID:</td>
        <td><?php echo $nid; ?></td>
    </tr>
    <tr>
        <td>Date of Delivary:</td>
        <td><?php echo $dod; ?></td>
    </tr>
    <tr>
        <td>Date of Expiry:</td>
        <td><?php echo $doe; ?></td>
    </tr>
    
</tbody>
</table>
<hr />
<h4 style="color:red;">are you sure you want to revoke this persons passport? </h4>
<a class ='my-2 btn btn-danger' href="revoke.u.php?id=<?php echo $appid; ?>">Revoke</a>
<a class ='btn btn-primary' href="adminidx.php">Dismiss</a>     
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