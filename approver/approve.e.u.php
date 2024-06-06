<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: loggin.php");
    exit;
}
if ($_SESSION['usertype'] != 'app') {
    header("location: loggin.php");

    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST['approval'];
    $appid = $_GET['id'];
    echo $appid. ' '. $data;
    include "includes/db.inc.php";
    $sql = "UPDATE application SET status = '$data' WHERE appid = '$appid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("location: approve.e.php?id=$appid"); 
    }


} else {
    echo "Sorry";
}