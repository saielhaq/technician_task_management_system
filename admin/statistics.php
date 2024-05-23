<?php
include ("../includes/connection.php");
session_start();

$currentMonth = date('m');
$currentYear = date('Y');
$taskQuery = "SELECT DAY(creation_date) as day, COUNT(*) as task_count FROM tasks WHERE YEAR(creation_date) = '$currentYear' AND MONTH(creation_date) = '$currentMonth' GROUP BY DAY(creation_date)";
$taskResult = mysqli_query($con, $taskQuery);
$daysInMonth = date('t');
$monthlyTaskData = array_fill(1, $daysInMonth, 0);

while ($row = mysqli_fetch_assoc($taskResult)) {
    $monthlyTaskData[$row['day']] = (int) $row['task_count'];
}

$completedTaskQuery = "SELECT DAY(close_date) as day, COUNT(*) as task_count FROM tasks WHERE YEAR(close_date) = '$currentYear' AND MONTH(close_date) = '$currentMonth' AND status = 'Terminé' GROUP BY DAY(close_date)";
$completedTaskResult = mysqli_query($con, $completedTaskQuery);
$monthlyCompletedTaskData = array_fill(1, $daysInMonth, 0);

while ($row = mysqli_fetch_assoc($completedTaskResult)) {
    $monthlyCompletedTaskData[$row['day']] = (int) $row['task_count'];
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
            <h3>Statistiques du mois</h3>
            <div>
                <canvas id="myChart"></canvas>
            </div>

            <script>
                const labels = Array.from({ length: <?php echo $daysInMonth; ?>}, (_, i) => i + 1);
                const data = {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Tâches crées',
                            data: <?php echo json_encode(array_values($monthlyTaskData)); ?>,
                            fill: false,
                            borderColor: 'rgba(75, 192, 192, 0.5)',
                            tension: 0.1
                        },
                        {
                            label: 'Tâches terminées',
                            data: <?php echo json_encode(array_values($monthlyCompletedTaskData)); ?>,
                            fill: false,
                            borderColor: 'rgba(255, 205, 86, 0.5)',
                            tension: 0.1
                        }]
                };
                const config = {
                    type: 'line',
                    data: data,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                };

                var myChart = new Chart(document.getElementById('myChart'), config);
            </script>

        </div>
    </div>

</body>

</html>