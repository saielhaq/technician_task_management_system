<?php
include ('../includes/connection.php');
if (isset($_POST['create_task'])) {
    $query = "insert into tasks values(null, null, '$_POST[description]', '$_POST[start_date]', '$_POST[end_date]', 'En attente', '$_POST[adress]')";
    $res = mysqli_query($con, $query);
    if ($res) {
        echo "<script>
            alert('Tâche créée avec succès');
            window.location.href = 'admin_dashboard.php';
        </script>";
    } else {
        echo "<script>
            alert('Une erreur est survenue, veuillez réessayer');
            window.location.href = 'admin_dashboard.php';
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
</head>

<body>
    <h3>Créer une nouvelle tâche</h3>
    <div class="row">
        <div class="col-md-6">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <!-- <div class="form-group">
                    <label>Choisir utilisateur:</label>
                    <select name="id" class="form-control">
                        <option value="">--Sélectionner--</option>
                        <?php
                        include ('../includes/connection.php');
                        $query = "select uid, name from users";
                        $res = mysqli_query($con, $query);
                        if (mysqli_num_rows($res)) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                ?>
                                <option value="<?php echo $row['uid']; ?>"><?php echo $row['name']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div> -->
                <div class="form-group">
                    <label>Description:</label>
                    <textarea class="form-control" name="description" rows="5" cols="50"
                        placeholder="Description de la tâche" style="resize:none"></textarea>
                </div>
                <div class="form-group">
                    <label>Localisation:</label>
                    <input type="text" class="form-control" name="adress">
                </div>
                <div class="form-group">
                    <label>Date début:</label>
                    <input type="date" class="form-control" name="start_date">
                </div>
                <div class="form-group">
                    <label>Date fin:</label>
                    <input type="date" class="form-control" name="end_date">
                </div>
                <input type="submit" class="btn btn-warning" name="create_task" value="Créer">
            </form>
        </div>
    </div>
</body>

</html>