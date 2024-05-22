<?php
include ('includes/connection.php');
if (isset($_POST['userRegistration'])) {
    $query = "insert into users values(null, '$_POST[name]', '$_POST[email]', '$_POST[password]', '$_POST[mobile]')";
    $res = mysqli_query($con, $query);
    if ($res) {
        echo "<script>
            alert('Utilisateur créé avec succès');
            window.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Erreur de création, veuillez réessayer');
            window.location.href = 'register.php';
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OMS | Inscription</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="includes/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div id="login_page">
            <h3 style="color:#ffffff">Inscription</h3><br>
            <form action="" method="post">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Nom complet" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Adresse mail" required>
                </div>
                <div class="form-group mt-3">
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                </div>
                <div class="form-group mt-3">
                    <input type="text" name="mobile" class="form-control" placeholder="Numéro de téléphone" required>
                </div>
                <div class="form-group mt-3">
                    <input type="submit" name="userRegistration" value="Register" class="btn btn-success w-100">
                </div>
            </form>
        </div>
    </div>
</body>

</html>