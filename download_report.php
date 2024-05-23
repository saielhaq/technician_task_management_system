<?php
session_start();
include ('includes/connection.php');
require_once ('includes/fpdf/fpdf.php');

if (isset($_GET['report_id'])) {
    $report_id = mysqli_real_escape_string($con, $_GET['report_id']);
    $query = "SELECT * FROM reports WHERE rid = '$report_id'";
    $result = mysqli_query($con, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $content = $row['content'];
        $filename = "Report_" . $report_id . ".pdf";

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Rapport tache numero:' . $report_id, 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 10, $content);
        $pdf->Output('D', $filename);

        exit;
    } else {
        echo "<script>alert('Erreur lors du téléchargement du rapport.'); window.location.href='reports.php';</script>";
    }
} else {
    echo "<script>alert('Aucun rapport spécifié pour le téléchargement.'); window.location.href='reports.php';</script>";
}
?>