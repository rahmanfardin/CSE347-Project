<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: loggin.php");
    exit;
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST['trxid'];
    $appid = $_POST['appid'];
    echo $appid. ' '. $data;
    include "includes/db.inc.php";
    $sql = "INSERT INTO payment(appid, paymentStatus) VALUES ('$appid','$data')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("location: makepayment.php"); 
    }


} else {
    echo "Sorry";
}