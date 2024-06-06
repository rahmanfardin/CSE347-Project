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


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $data = "approved";
    $appid = $_GET['id'];
    echo $appid. ' '. $data;
    include "includes/db.inc.php";
    $sql = "UPDATE revokeapplication SET status = '$data' WHERE PassportID = '$appid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("location: adminidx.php"); 
    }


} else {
    echo "Sorry";
}