<html>

<body>
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
        include ('../includes/connection.php');

        if (isset($_POST['delete_id'])) {
            $delete_id = mysqli_real_escape_string($con, $_POST['delete_id']);
            $delete_query = "DELETE FROM tasks WHERE tid = '$delete_id'";
            $delete_result = mysqli_query($con, $delete_query);
            if ($delete_result) {
                echo "<script>alert('Tâche supprimée avec succès'); window.location.href='admin_dashboard.php';</script>";
            } else {
                echo "<script>alert('Échec de la suppression de la tâche'); window.location.href='admin_dashboard.php';</script>";
            }
        }
        $num = 1;
        $query = "SELECT *, IFNULL(u.name, '') AS user_name FROM tasks t LEFT JOIN users u ON t.uid = u.uid";
        $res = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr><td>{$num}</td><td>" . ($row['user_name'] !== null ? $row['user_name'] : "") . "</td><td>{$row['description']}</td><td>{$row['start_date']}</td><td>{$row['end_date']}</td><td>{$row['status']}</td><td>{$row['location']}</td><td><a href='edit_task.php?id={$row['tid']}' class='btn btn-warning'>Modifier</a>|<form method='POST' action='{$_SERVER['PHP_SELF']}' style='display:inline;'><input type='hidden' name='delete_id' value='{$row['tid']}'><button type='submit' class='btn btn-danger' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette tâche ?\");'>Supprimer</button></form></td></tr>";
            $num++;
        } ?>
    </table>
</body>

</html>