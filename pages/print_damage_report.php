<?php
require '../vendor/autoload.php';
require '../fpdf/fpdf.php';

require "../includes/connection.php";

$query = "SELECT 
            a.*, 
            e.FIRST_NAME, 
            e.LAST_NAME 
        FROM approved_items a  
        JOIN employee e ON a.employee_id = e.EMPLOYEE_ID
        WHERE stand_by = 0";

$result = mysqli_query($db, $query);
// Checkout ID:
// Date returned:
// Equipment Name:
// Borrower:
// Don
// and
// Status:

class PDF extends FPDF
{

    public function header()
    {
        $this->SetFont('Arial', 'B');
        $this->SetFontSize(16);
        $this->Cell(0, 12, 'Damage Report', 1, 1, 'C');
        $this->Cell(0, 12, '', 1, 1);
    }
}

$pdf = new PDF();
// Setters
// Config
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(45, 9, 'Equipment Name', 1, 0, 'C');
$pdf->Cell(59, 9, 'Checkout Id', 1, 0, 'C');
$pdf->Cell(29, 9, 'Status', 1, 0, 'C');
$pdf->Cell(27, 9, 'Borrower', 1, 0, 'C');
$pdf->Cell(30, 9, 'Date Approved', 1, 1, 'C');
$pdf->SetFont('Times', '', 10);

while ($row = mysqli_fetch_assoc($result)) {
    $pdf->SetFont('Times', '', 8);
    $pdf->Cell(45, 9, $row['name'], 1, 0, 'C');
    $pdf->Cell(59, 9, $row['checkout_id'], 1, 0, 'C');
    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(29, 9, $row['status'], 1, 0, 'C');
    $pdf->Cell(27, 9, $row['FIRST_NAME'] . " " . $row['LAST_NAME'] , 1, 0, 'C');
    $str = strtotime($row['date_approved']);
    $checkout_date = date('Y-m-d', $str);
    $pdf->Cell(30, 9, $checkout_date, 1, 1, 'C');
}

$pdf->Output();
