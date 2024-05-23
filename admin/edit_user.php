<?php
include ('../includes/connection.php');
session_start();
if (isset($_GET['uid'])) {
    $uid = mysqli_real_escape_string($con, $_GET['uid']);
    $query = "SELECT * FROM users WHERE uid = '$uid'";
    $result = mysqli_query($con, $query);
    if ($result) {
        $user = mysqli_fetch_assoc($result);
        ?>
        <html>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>OMS | Admin Dashboard</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/dashboard.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../includes/jquery-3.7.1.min.js"></script>

        <body>
            <div id="header" class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3>OMS | Admin Dashboard</h3>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <b>Email:</b> <?php echo $_SESSION['email']; ?>
                        <b>Nom:</b> <?php echo $_SESSION['name']; ?>
                    </div>
                </div>
            </div>
            <div class="sidebar-container">
                <div class="col-md-2" id="left-sidebar">
                    <table class="table">
                        <tr>
                            <td><a href="admin_dashboard.php" type="button">Dashboard</a></td>
                        </tr>
                        <tr>
                            <td><a href="add_technician.php" type="button">Ajouter un technicien</a></td>
                        </tr>
                        <tr>
                            <td><a type="button" id="manage_technicians">Gérer les techniciens</a></td>
                        </tr>
                        <tr>
                            <td><a type="button" id="create_task">Créer tâche</a></td>
                        </tr>
                        <tr>
                            <td><a type="button" id="manage_task">Gérer tâches</a></td>
                        </tr>
                        <tr>
                            <td><a href="reports.php" type="button" id="reports">Rapports</a></td>
                        </tr>
                        <tr>
                            <td><a href="../logout.php" type="button" id="logout_link">Se déconnecter</a></td>
                        </tr>
                    </table>
                </div>
                <div id="right-sidebar">
                    <?php
                    include ('../includes/connection.php');
                    if (isset($_POST['update_user'])) {
                        $uid = mysqli_real_escape_string($con, $_POST['uid']);
                        $name = mysqli_real_escape_string($con, $_POST['name']);
                        $email = mysqli_real_escape_string($con, $_POST['email']);

                        $update_query = "UPDATE users SET name='$name', email='$email' WHERE uid='$uid'";
                        $update_result = mysqli_query($con, $update_query);

                        if ($update_result) {
                            echo "<script>alert('Informations mises à jour avec succès.'); window.location.href='admin_dashboard.php';</script>";
                        } else {
                            echo "<script>alert('Erreur lors de la mise à jour des informations.');</script>";
                        }
                    }
                    ?>
                    <form action="" method="post" class="form-group">
                        <input type="hidden" name="uid" value="<?php echo htmlspecialchars($_GET['uid']); ?>">
                        <label for="name" class="form-label">Nom:</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>"
                            class="form-control"><br>
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                            class="form-control"><br>
                        <input type="submit" name="update_user" value="Mettre à jour" class="btn btn-warning">
                    </form>
                </div>
            </div>

        </body>

        </html>
        <?php
    } else {
        echo "<script>alert('Utilisateur non trouvé.'); window.location.href='admin_dashboard.php';</script>";
    }
} else {
    echo "<script>alert('Aucun identifiant d'utilisateur fourni.'); window.location.href='admin_dashboard.php';</script>";
}
?>