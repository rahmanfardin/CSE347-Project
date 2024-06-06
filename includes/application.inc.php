<?php


function allFieldsEntered($fname, $lname, $fathername , $mothername , $email ,$phone , $nid , $address, $dob){
    if ($fname and $lname and $fathername and $mothername and $email and $phone and $nid and $address and $dob) return true;
    else return false;
}
function checkIfApplicationExists($username, $conn){
    $existsSql = "SELECT * FROM `application` WHERE `username` = '$username'; ";
    $result = mysqli_query($conn, $existsSql);
    $numOfUsers = mysqli_num_rows($result);
    if ($numOfUsers == 0) return false;
    else return true;
}
function checkIfPassportExists($username, $conn){
    $existsSql = "SELECT * FROM `passport` WHERE `username` = '$username'; ";
    $result = mysqli_query($conn, $existsSql);
    $numOfUsers = mysqli_num_rows($result);
    if ($numOfUsers == 0) return false;
    else return true;
}function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}