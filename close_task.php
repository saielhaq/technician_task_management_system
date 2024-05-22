<?php
include ('includes/connection.php');
session_start();


if (isset($_POST['close_task'])) {
    $query = "UPDATE tasks SET status = 'Terminé' WHERE tid = '$_POST[task_id]'";
    $res = mysqli_query($con, $query);
    $reportQuery = "INSERT INTO reports VALUES (NULL, '" . $_POST['task_id'] . "', '" . $_SESSION['uid'] . "', '$_POST[rapport]')";
    $reportResult = mysqli_query($con, $reportQuery);
    if (!$reportResult) {
        echo "<script>alert('Erreur lors de la création du rapport');</script>";
    }

    if ($res) {
        echo "<script>alert('Tâche clôturée avec succès'); window.location.href='manage_task.php';</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">




<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OMS | User dashboard</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="includes/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#manage_task').click(function () {
                $("#right-sidebar").load("manage_task.php");
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
                    <td style="text-align: center"><a href="user_dashboard.php" type="button">Dashboard</a></td>
                </tr>
                <tr>
                    <td><a href="manage_task.php" type="button" id="manage_task">Tâches</a></td>
                </tr>
                <tr>
                    <td><a href="reports.php" type="button" id="manage_task">Rapports</a></td>
                </tr>
                <tr>
                    <td style="text-align: center"><a href="logout.php" type="button" id="logout_link">Se
                            déconnecter</a></td>
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
                        <input type="hidden" name="task_id" value="<?php echo $_GET['tid']; ?>">
                        <input type="submit" class="btn btn-warning" name="close_task" value="Clôturer">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>