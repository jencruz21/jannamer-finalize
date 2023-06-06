<?php
require_once "../includes/connection.php";
$empId = $_GET['emp_id'];

$employee_qrcode_result = mysqli_query($db, "SELECT QR_CODE_TEXT, QR_CODE_IMG_PATH FROM employee WHERE EMPLOYEE_ID = '{$empId}'");
$empolyee_qrcode = mysqli_fetch_assoc($employee_qrcode_result);
$file = $empolyee_qrcode['QR_CODE_IMG_PATH'];

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
?>