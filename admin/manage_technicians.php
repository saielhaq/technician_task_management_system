<html>

<body>
    <center>
        <h3>Toutes les tâches:</h3>
    </center>
    <table class="table">
        <tr>
            <th>N°</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Nombre de tâches terminées</th>
            <th colspan="2">Action</th>
        </tr>
        <?php
        include ('../includes/connection.php');

        if (isset($_POST['delete_id'])) {
            $delete_id = mysqli_real_escape_string($con, $_POST['delete_id']);
            $delete_query = "DELETE FROM users WHERE uid = '$delete_id'";
            $delete_result = mysqli_query($con, $delete_query);
            if ($delete_result) {
                echo "<script>alert('Technicien supprimé avec succès'); window.location.href='admin_dashboard.php';</script>";
            } else {
                echo "<script>alert('Échec de la suppression du technicien'); window.location.href='admin_dashboard.php';</script>";
            }
        }

        $num = 1;
        $query = "SELECT u.uid, u.name, u.email, COUNT(t.tid) AS finished_tasks FROM users u LEFT JOIN tasks t ON u.uid = t.uid AND t.status = 'Terminé' GROUP BY u.uid";
        $res = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr><td>{$num}</td><td>{$row['name']}</td><td>{$row['email']}</td><td>{$row['finished_tasks']}</td><td><a href='edit_user.php?uid={$row['uid']}' class='btn btn-warning'>Modifier</a></td><td><form method='POST' action='{$_SERVER['PHP_SELF']}'><input type='hidden' name='delete_id' value='{$row['uid']}'><button type='submit' class='btn btn-danger' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce technicien ?\");'>Supprimer</button></form></td></tr>";
            $num++;
        } ?>
    </table>
</body>

</html>