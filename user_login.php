<?php
include ('includes/connection.php');
session_start();

if (isset($_POST['userLogin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT email, password, name, uid FROM users WHERE email = '$email' AND password = '$password'";
    $res = mysqli_query($con, $query);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['email'] = $row['email'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['uid'] = $row['uid'];
        header('Location: user_dashboard.php');
    } else {
        echo "<script>
            alert('Email ou mot de passe incorrect');
            window.location.href = 'user_login.php';
        </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OMS | User login</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="includes/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div id="login_page">
            <h3 style="color:#ffffff">User Login</h3><br>
            <form action="" method="post">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Adresse mail" required>
                </div>
                <div class="form-group mt-3">
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                </div>
                <div class="form-group mt-3">
                    <input type="submit" name="userLogin" value="Login" class="btn btn-success w-100">
                </div>
            </form>
        </div>
    </div>
</body>

</html>