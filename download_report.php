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
        $user_id = $row['uid'];
        $filename = "Report_" . $report_id . ".pdf";

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Rapport tache numero:' . $report_id, 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 10, $content);

        $user_query = "SELECT name FROM users WHERE uid = '$user_id'";
        $user_result = mysqli_query($con, $user_query);
        if ($user_result) {
            $user_row = mysqli_fetch_assoc($user_result);
            $user_name = $user_row['name'];
            $pdf->Ln(20);
            $pdf->SetFont('Arial', 'I', 12);
            $pdf->Cell(0, 10, 'Signature: ' . $user_name, 0, 1, 'L');
        }

        $pdf->Output('D', $filename);

        exit;
    } else {
        echo "<script>alert('Erreur lors du téléchargement du rapport.'); window.location.href='reports.php';</script>";
    }
} else {
    echo "<script>alert('Aucun rapport spécifié pour le téléchargement.'); window.location.href='reports.php';</script>";
}
?>