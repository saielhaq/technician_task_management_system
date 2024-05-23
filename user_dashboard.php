<?php
include ('includes/connection.php');
session_start();

$query = "select count(tid) as count from tasks";
$query2 = "select count(tid) as pending from tasks where status = 'En attente'";
$query3 = "select count(tid) as finished from tasks where status = 'Terminé'";
$query4 = "select count(tid) as en_cours from tasks where status = 'En cours'";
$res = mysqli_query($con, $query);
$res2 = mysqli_query($con, $query2);
$res3 = mysqli_query($con, $query3);
$res4 = mysqli_query($con, $query4);
if ($res) {
    $row = mysqli_fetch_array($res);
    $total = $row['count'];
}
if ($res2) {
    $row = mysqli_fetch_array($res2);
    $pending = $row['pending'];
}
if ($res3) {
    $row = mysqli_fetch_array($res3);
    $finished = $row['finished'];
}
if ($res4) {
    $row = mysqli_fetch_array($res4);
    $en_cours = $row['en_cours'];
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
                    <td><a href="manage_task.php" type="button" id="manage_task">Tâches disponibles</a></td>
                </tr>
                <tr>
                    <td><a href="manage_task.php" type="button" id="manage_task">Mes tâches</a></td>
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
            <h3>Nombre de tâches total: <?php echo $total; ?></h3>
            <h3>Nombre de tâches en attente: <?php echo $pending; ?></h3>
            <h3>Nombre de tâches en cours: <?php echo $en_cours; ?></h3>
            <h3>Nombre de tâches terminées: <?php echo $finished; ?></h3>
        </div>
    </div>
</body>

</html>