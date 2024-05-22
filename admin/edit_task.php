<?php
include ('../includes/connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_status'])) {
        $task_id = $_POST['task_id'];
        $new_status = $_POST['status'];

        if (!empty($task_id) && !empty($new_status)) {
            $task_id = mysqli_real_escape_string($con, $task_id);
            $new_status = mysqli_real_escape_string($con, $new_status);

            $query = "UPDATE tasks SET status = '$new_status' WHERE tid = '$task_id'";
            $result = mysqli_query($con, $query);

            if ($result) {
                echo '<script>alert("Task status updated successfully.");</script>';
                echo '<script>window.location.href="admin_dashboard.php";</script>';
            } else {
                echo '<script>alert("Failed to update task status.");</script>';
            }
        } else {
            echo '<script>alert("Invalid task ID or status.");</script>';
        }
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
                    <td><a href="add_technician.php" type="button">Ajouter un technicien</a></td>
                </tr>
                <tr>
                    <td><a href="manage_technician.php" type="button">Gérer les techniciens</a></td>
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
                        <input type="hidden" name="task_id" value="<?php echo $_GET['id']; ?>">
                        <input type="submit" class="btn btn-warning" name="update_status" value="Modifier">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>