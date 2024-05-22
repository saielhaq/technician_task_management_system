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
                <td><a href="edit_task.php?id=<?php echo $row['tid'] ?>" class="btn btn-warning">Modifier</a>|<a
                        href="delete_task.php?id=<?php echo $row['tid'] ?>" class="btn btn-danger">Supprimer</a></td>

            </tr>
            <?php
            $num++;
        } ?>


    </table>
</body>

</html>