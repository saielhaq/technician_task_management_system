<?php
include ('../includes/connection.php');
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
    <title>OMS | Admin Dashboard</title>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

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

            <h3>Statistiques générales</h3>
            <div style="display: flex; justify-content: space-between;">
                <div style="width: 45%;">
                    <canvas id="myChart"></canvas>
                </div>
                <div id="taskIndicator"
                    style="width: 45%; display: flex; align-items: center; justify-content: center;">
                </div>
            </div>
            <script>
                const pendingTasks = <?php echo $pending; ?>;
                const inProgressTasks = <?php echo $en_cours; ?>;
                const finishedTasks = <?php echo $finished; ?>;

                const data = {
                    labels: [
                        'En attente',
                        'En cours',
                        'Terminé'
                    ],
                    datasets: [{
                        label: 'Nombre de tâches',
                        data: [pendingTasks, inProgressTasks, finishedTasks],
                        backgroundColor: [
                            'rgb(54, 162, 235)',
                            'rgb(255, 165, 0)',
                            'rgb(0, 128, 0)'
                        ],
                        hoverOffset: 4
                    }]
                };
                const config = {
                    type: 'doughnut',
                    data: data,
                    options: {}
                };
                const myChart = new Chart(
                    document.getElementById('myChart'),
                    config
                );

                const taskDifference = pendingTasks - inProgressTasks;
                const indicatorElement = document.getElementById('taskIndicator');
                let indicatorColor = '';
                let indicatorText = '';

                if (taskDifference < 5) {
                    indicatorColor = 'green';
                    indicatorText = 'Situation Stable';
                } else if (taskDifference >= 5 && taskDifference < 10) {
                    indicatorColor = 'yellow';
                    indicatorText = 'Attention Requise';
                } else {
                    indicatorColor = 'red';
                    indicatorText = 'Situation Critique';
                }

                indicatorElement.style.backgroundColor = indicatorColor;
                indicatorElement.innerHTML = `<span style="color: white; font-size: 1.5em;">${indicatorText}</span>`;
            </script>
        </div>
    </div>
</body>

</html>