<?php
include ('../includes/connection.php');
session_start();

if (isset($_POST['edit_task'])) {
    $id = $_SESSION['id'];
    $getStatusQuery = "SELECT status AS currentStatus FROM tasks WHERE tid = $_GET[id]";
    $statusRes = mysqli_query($con, $getStatusQuery);
    if ($statusRes) {
        $row = mysqli_fetch_array($statusRes);
        $currStatus = $row['currentStatus'];
    }

    if ($_POST['status'] == $currStatus) {
        header('Location: admin_dashboard.php');
    } else {
        $query = "UPDATE tasks SET status = '$_POST[newStatus]' WHERE tid = $_GET[id]";
        mysqli_query($con, $query);
        header('Location: admin_dashboard.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OMS | Admin Dashboard</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../includes/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div id="header" class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3>OMS | Admin</h3>
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
                    <td><a type="button" id="create_task">Créer tâche</a></td>
                </tr>
                <tr>
                    <td><a type="button" id="manage_task">Gérer tâches</a></td>
                </tr>
                <tr>
                    <td><a href="../logout.php" type="button" id="logout_link">Se déconnecter</a></td>
                </tr>
            </table>
        </div>
        <div id="right-sidebar">
            <div class="row">
                <div class="col-md-4 m-auto">
                    <h3><i class="fa fa-solid fa-list"></i> Modifier la tâche</h3>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">--Selectionner--</option>
                                <option value="En attente">En attente</option>
                                <option value="En cours">En cours</option>
                                <option value="Terminé">Terminée</option>
                                <option value="Annulé">Annulée</option>
                            </select>
                        </div>
                        <input type="submit" class="btn btn-warning" name="edit_task" value="Modifier">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>