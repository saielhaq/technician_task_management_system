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
                    <td><a href="logout.php" type="button" id="logout_link">Se déconnecter</a></td>
                </tr>
            </table>
        </div>
        <div id="right-sidebar">
            <center>
                <h3>Toutes les tâches:</h3>
            </center>
            <table class="table">
                <tr>
                    <th>N°</th>
                    <th>Technicien</th>
                    <th>Description</th>
                    <th>Date debut</th>
                    <th>Date fin</th>
                    <th>Status</th>
                    <th>Locatisation</th>
                    <th>Action</th>
                </tr>
                <?php
                include ('includes/connection.php');
                $num = 1;
                $query = "SELECT *, IFNULL(u.name, '') AS user_name FROM tasks t LEFT JOIN users u ON t.uid = u.uid";
                $res = mysqli_query($con, $query);
                while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                    <tr>
                        <td><?php echo $num ?></td>
                        <td><?php echo ($row['user_name'] !== null) ? $row['user_name'] : ""; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['start_date']; ?></td>
                        <td><?php echo $row['end_date']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['location']; ?></td>
                        <td>
                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="accept_task_id" value="<?php echo $row['tid']; ?>">
                                <button type="submit" name="accept_task" class="btn btn-success">Accepter</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                    $num++;
                }

                if (isset($_POST['accept_task'])) {
                    $task_id = $_POST['accept_task_id'];
                    $query = "UPDATE tasks SET status = 'En cours' WHERE tid = $task_id";
                    mysqli_query($con, $query);
                    $query = "UPDATE tasks SET uid = " . $_SESSION['uid'] . " WHERE tid = " . $task_id;
                    mysqli_query($con, $query);
                    echo "<script>window.location.href='manage_task.php';</script>";
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>