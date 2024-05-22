<?php
include ('../includes/connection.php');
session_start();

if (isset($_POST['adminLogin'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $query = "SELECT email, password, name, id FROM admins WHERE email = ? AND password = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['email'] = $row['email'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['id'] = $row['id'];

        header('Location: admin_dashboard.php');
        exit();
    } else {
        echo "<script>
            alert('Email ou mot de passe incorrect');
            window.location.href = 'admin_login.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OMS | Admin login</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../includes/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div id="login_page">
            <h3 style="color:#ffffff">Admin Login</h3><br>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="email" name="email" class="login_input" placeholder="Adresse mail" required>
                <input type="password" name="password" class="login_input mt-3" placeholder="Mot de passe" required>
                <input type="submit" name="adminLogin" value="Login" class="login_btn mt-3">
            </form>
        </div>
    </div>
</body>

</html>