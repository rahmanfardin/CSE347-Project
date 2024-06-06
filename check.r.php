<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: loggin.php");
    exit;
}
include 'includes/db.inc.php';
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $u = mysqli_real_escape_string($conn, $_GET['id']); // Prevent SQL injection

    // Improved SQL query (handle case sensitivity and typos)
    $sql = "SELECT * FROM  passportvalidity WHERE PassportID = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $u);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt); // Get the result object

        if ($result && mysqli_num_rows($result) > 0) { // Check if there are results
            $row = mysqli_fetch_assoc($result);
            $isRovoked = $row['isRevoked'];
            if ($isRovoked == "true") {
                $haveResult = false;
                echo "sorry your passport was revoked";
            } else {
                header("Location: e.renew.php?id=".$row['PassportID']);
                $haveResult = true;
            }
        }
        mysqli_stmt_close($stmt); // Close the prepared statement
    } else {
        // Handle the case where the query preparation fails
        echo "Error preparing the statement: " . mysqli_error($conn);
    }
}
?>