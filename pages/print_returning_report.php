<?php
require '../vendor/autoload.php';
require '../fpdf/fpdf.php';

require "../includes/connection.php";

class PDF extends FPDF
{

    public function header()
    {
        $this->SetFont('Arial', 'B');
        $this->SetFontSize(16);
        $this->Cell(0, 12, 'Returned Items', 1, 1, 'C');
        $this->Cell(0, 12, '', 1, 1);
    }
}

// Equipment
// Status
// Price
// Amount Returned
// Returned Status
// Date returned

if (isset($_POST['print'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $query = "SELECT * FROM returned_items WHERE date_returned BETWEEN '{$start_date}' AND '{$end_date}'";

    $result = mysqli_query($db, $query);
// Checkout ID:
// Date returned:
// Equipment Name:
// Borrower:
// Don
// and
// Status:

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();

    $pdf->SetFont('Times', 'B', 10);
    $pdf->Cell(65, 9, 'Item Name', 1, 0, 'C');
    $pdf->Cell(29, 9, 'Price', 1, 0, 'C');
    $pdf->Cell(29, 9, 'Status', 1, 0, 'C');
    $pdf->Cell(37, 9, 'Amount Returned', 1, 0, 'C');
    $pdf->Cell(30, 9, 'Date Returned', 1, 1, 'C');
    $pdf->SetFont('Times', '', 10);

    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(65, 9, $row['name'], 1, 0, 'C');
        $pdf->Cell(29, 9, 'P ' . $row['price'], 1, 0, 'C');
        $pdf->Cell(29, 9, $row['status'], 1, 0, 'C');
        $pdf->Cell(37, 9, $row['qty'], 1, 0, 'C');
        $str = strtotime($row['date_returned']);
        $checkout_date = date('Y-m-d', $str);
        $pdf->Cell(30, 9, $checkout_date, 1, 1, 'C');
    }

    $pdf->Output();
} else {
    die();
}