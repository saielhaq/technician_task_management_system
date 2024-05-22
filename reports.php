<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OMS | Gérer les tâches</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="includes/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div id="header" class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3>OMS | Gérer les tâches</h3>
            </div>
        </div>
    </div>
    <div class="sidebar-container">
        <div class="col-md-2" id="left-sidebar">
            <table class="table">
                <tr>
                    <td><a href="user_dashboard.php" type="button">Dashboard</a></td>
                </tr>
                <tr>
                    <td><a href="manage_task.php" type="button" id="manage_task">Tâches</a></td>
                </tr>
                <tr>
                    <td><a href="reports.php" type="button" id="reports">Rapports</a></td>
                </tr>
                <tr>
                    <td><a href="logout.php" type="button" id="logout_link">Se déconnecter</a></td>
                </tr>
            </table>
        </div>
        <div id="right-sidebar">
            <center>
                <h3>Mes rapports</h3>
            </center>
            <table class="table">
                <tr>
                    <th>N°</th>
                    <th>Tâche</th>
                    <th>Rapport</th>
                    <th colspan="3">
                        <center>Actions</center>
                    </th>
                </tr>
                <?php
                include "includes/connection.php";

                if (isset($_POST['delete_report_id'])) {
                    $delete_report_id = mysqli_real_escape_string($con, $_POST['delete_report_id']);
                    $delete_query = "DELETE FROM reports WHERE rid = '$delete_report_id'";
                    $delete_result = mysqli_query($con, $delete_query);
                    if ($delete_result) {
                        echo "<script>alert('Rapport supprimé avec succès');</script>";
                    } else {
                        echo "<script>alert('Échec de la suppression du rapport');</script>";
                    }
                }

                $query = "SELECT reports.*, tasks.description, users.name FROM reports JOIN tasks ON reports.tid = tasks.tid JOIN users ON reports.uid = users.uid";
                $result = mysqli_query($con, $query);
                $num = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $num++ . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["content"] . "</td>";
                    echo "<td><a href='download_report.php?report_id=" . $row['rid'] . "' class='btn btn-success'>Télécharger</a></td>";
                    echo "<td><a href='edit_report.php?report_id=" . $row['rid'] . "' class='btn btn-warning'>Modifier</a></td>";
                    echo "<td><form method='POST' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'><input type='hidden' name='delete_report_id' value='" . $row['rid'] . "'><button type='submit' class='btn btn-danger' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce rapport ?\");'>Supprimer</button></form></td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>