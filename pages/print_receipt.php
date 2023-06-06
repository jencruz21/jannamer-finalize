<?php
require '../vendor/autoload.php';
require '../fpdf/fpdf.php';

require "../includes/connection.php";

$id = mysqli_real_escape_string($db, $_GET['checkout_id']);
$result = mysqli_query($db, "SELECT cd.*, 
e.FIRST_NAME, 
e.LAST_NAME, 
e.JOB_ID,
v.NAME as VEHICLE_NAME, 
v.AVAILABILITY, 
v.ID as v_vehicle_id, 
v.CHECKOUT_ID as v_checkout_id
FROM checkout_details cd 
JOIN employee e ON cd.employee_id = e.EMPLOYEE_ID 
JOIN vehicle v ON cd.vehicle_id = v.ID 
WHERE cd.checkout_id = '{$id}'");
$details = mysqli_fetch_assoc($result);

class PDF extends FPDF
{
    private $checkout_id;
    private $amount_paid;
    private $total_cost;
    private $customer_name;
    private $customer_position;
    private $checkout_date;

    public function header()
    {
        $this->SetFont('Arial', 'B');
        $this->SetFontSize(16);
        $this->Cell(0, 12, 'Transaction Receipt - #' . $this->checkout_id, 1, 1, 'C');
        $this->Cell(0, 12, '', 1, 1);
    }

    public function subHeader()
    {
        // total page length is 190
        //
        $this->SetFont('Arial');
        $this->SetFontSize(10);
        //upper subheader

        $this->Cell(47.5, 9, 'Amount Paid', 1, 0, 'C');
        $this->Cell(47.5, 9, $this->amount_paid, 1, 0);
        $this->Cell(47.5, 9, 'Total Cost', 1, 0, 'C');
        $this->Cell(47.5, 9, $this->total_cost, 1, 1);
        // lower subheader
        $this->Cell(47.5, 9, 'Customer Name', 1, 0, 'C');
        $this->Cell(47.5, 9, $this->customer_name, 1, 0);
        $this->Cell(47.5, 9, 'Customer Position', 1, 0, 'C');
        $this->Cell(47.5, 9, $this->customer_position, 1, 1);

        $this->Cell(37.5, 9, 'Checkout Date', 1, 0, 'C');
        $this->Cell(37.5, 9, $this->checkout_date, 1, 0);
        $this->Cell(37.5, 9, 'Checkout ID', 1, 0, 'C');
        $this->Cell(77.5, 9, $this->checkout_id, 1, 1);
        $this->Cell(0, 12, '', 0, 1);
    }

    public function setCheckoutId($checkout_id) {
        $this->checkout_id = $checkout_id;
    }

    public function setAmountPaid($amount_paid) {
        $this->amount_paid = $amount_paid;
    }

    public function setTotalCost($total_cost) {
        $this->total_cost = $total_cost;
    }

    public function setCustomerName($customer_name) {
        $this->customer_name = $customer_name;
    }

    public function setCustomerPosition($customer_position) {
        $this->customer_position = $customer_position;
    }

    public function setCheckoutDate($checkout_date) {
        $str = strtotime($checkout_date);
        $checkout_date = date('Y-m-d g:i A', $str);
        $this->checkout_date = $checkout_date;
    }
}

$pdf = new PDF();
// Setters
// Config
$pdf->setCheckoutId($details['checkout_id']);
$pdf->setAmountPaid($details['amount_paid']);
$pdf->setTotalCost($details['total_cost']);
$pdf->setCustomerName($details['FIRST_NAME'] . " " . $details['LAST_NAME']);
$pdf->setCustomerPosition($details['JOB_ID'] == 1 ? "Engineer" : "Employee");
$pdf->setCheckoutDate($details['checkout_date']);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->subHeader();

$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(27.1428571 * 2, 9, 'Item Name', 1, 0, 'C');
$pdf->Cell(24.1428571, 9, 'Unit', 1, 0, 'C');
$pdf->Cell(30.1428571, 9, 'Type', 1, 0, 'C');
$pdf->Cell(27.1428571, 9, 'Status', 1, 0, 'C');
$pdf->Cell(17.1428571, 9, 'Price', 1, 0, 'C');
$pdf->Cell(37.1428571, 9, 'Date', 1, 1, 'C');

$result2 = mysqli_query($db, "SELECT * FROM checkout_items WHERE chkout_id = '{$details['checkout_id']}'");
$pdf->SetFont('Times', '', 10);
while ($row = mysqli_fetch_assoc($result2)) {
    $pdf->Cell(27.1428571 * 2, 9, $row['name'], 1, 0, 'C');
    $pdf->Cell(24.1428571, 9, $row['unit'], 1, 0, 'C');
    $pdf->Cell(30.1428571, 9, $row['type'], 1, 0, 'C');
    $pdf->Cell(27.1428571, 9, $row['status'], 1, 0, 'C');
    $pdf->Cell(17.1428571, 9, $row['price'], 1, 0, 'C');
    $str = strtotime($row['date_purchased']);
    $checkout_date = date('Y-m-d g:i A', $str);
    $pdf->Cell(37.1428571, 9, $checkout_date, 1, 1, 'C');
}

$pdf->Output();
