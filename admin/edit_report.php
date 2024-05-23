<?php
include ('../includes/connection.php');
session_start();


if (isset($_POST['edit_task'])) {
    $query = "UPDATE reports SET content = '$_POST[rapport]' WHERE rid = '$_POST[task_id]'";
    $res = mysqli_query($con, $query);
    if (!$res) {
        echo "<script>alert('Erreur lors de la création du rapport'); window.location.href='reports.php';</script>";
    }

    if ($res) {
        echo "<script>alert('Tâche modifiée avec succès'); window.location.href='reports.php';</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OMS | User dashboard</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../includes/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#create_task").click(function () {
                $("#right-sidebar").load("./create_task.php");
            });
        });
        $(document).ready(function () {
            $("#manage_task").click(function () {
                $("#right-sidebar").load("./manage_task.php");
            });
        });
        $(document).ready(function () {
            $("#manage_technicians").click(function () {
                $("#right-sidebar").load("./manage_technicians.php");
            });
        });
    </script>
</head>

<body>
    <div id="header" class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3>OMS | User Dashboard</h3>
            </div>
            <div class="col-md-6 text-md-end">
                <b>Email:</b> <?php echo $_SESSION['email']; ?>
                <b>Nom:</b> <?php echo $_SESSION['name']; ?>
            </div>
        </div>
    </div>
    <div>
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
                    <td><a type="button" href="statistics.php">Statistiques tâches</a></td>
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
                            <label>Rapport</label>
                            <textarea class="form-control" name="rapport" id="rapport" rows="5" cols="50"
                                placeholder="Rapport de la tâche" style="resize:none"></textarea>
                        </div>
                        <input type="hidden" name="task_id" value="<?php echo $_GET['report_id']; ?>">
                        <input type="submit" class="btn btn-warning" name="edit_task" value="Enregistrer">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>