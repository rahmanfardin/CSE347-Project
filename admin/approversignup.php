
<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: loggin.php");
  exit;
}if ($_SESSION['usertype'] != 'admin'){
    header("location: loggin.php");
    
    exit;
  }


$showAlert = false;
$showError = false;
$showtype = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'includes/db.inc.php';
    include 'includes/signup.inc.php';
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $userType = "app";

    $usernameEsistsCheck = usernameEsists($username, $conn);
    $emailExistsCheck = emailExists($email, $conn);
    $passwordMatched = passwordCheck($password, $cpassword);
    if (!$usernameEsistsCheck and !$emailExistsCheck and $passwordMatched) {
        $hashedPass = hash('sha256', $password);
        $sql = "INSERT INTO `usertable`( `name`, `email`, `username`, `password`, userType) VALUES ('$name','$email','$username','$hashedPass', '$userType')";
        $showtype = $userType;
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $showAlert = true;
        }
    } else {
        if ($usernameEsistsCheck)
            $showError = $showError . "| username exists |";
        if ($emailExistsCheck)
            $showError = $showError . "| email exists |";
        if (!$passwordMatched)
            $showError = $showError . "| passwords dont match |";
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


    <title>SignUp</title>
</head>

<body>
    <header>
        <div class="container">
        <?php require 'includes/header.inc.php' ?>
        <hr />
            <div>
                <?php
                if ($showAlert) {
                    echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Approver account is now created'. '
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

                <div class="container my+4">
                    <h1 class="text-center" style="color:green;">Signup<br>New Approver</h1>
                    <form action="approversignup.php" method="post" class="starlabel">
                        <div class="form-group">
                            <label for="name" style="color:green;">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>

                        </div>
                        <div class="form-group">
                            <label for="email" style="color:green;">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                aria-describedby="emailHelp" required>

                        </div>
                        <div class="form-group">
                            <label for="username" style="color:green;">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>

                        </div>
                        <div class="form-group">
                            <label for="password" style="color:green;">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="cpassword" style="color:green;">Confirm Password</label>
                            <input type="password" class="form-control" id="cpassword" name="cpassword" required>
                            <small id="emailHelp" class="form-text text-muted">Make sure to type the same
                                password</small>
                        </div>

                        <button type="submit" class="btn btn-primary my-4">SignUp</button>
                    </form>
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