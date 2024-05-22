<?php
session_start();
include ('../includes/connection.php');

if (isset($_GET['report_id'])) {
    $report_id = mysqli_real_escape_string($con, $_GET['report_id']);
    $query = "SELECT * FROM reports WHERE rid = '$report_id'";
    $result = mysqli_query($con, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $content = $row['content'];
        $filename = "Report_" . $report_id . ".txt";
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($content));
        echo $content;
        exit;
    } else {
        echo "<script>alert('Erreur lors du téléchargement du rapport.'); window.location.href='reports.php';</script>";
    }
} else {
    echo "<script>alert('Aucun rapport spécifié pour le téléchargement.'); window.location.href='reports.php';</script>";
}
?>