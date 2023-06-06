<?php 
include '../includes/connection.php';
require_once "../phpqrcode/qrlib.php";

$emp_id = $_GET['emp_id'];

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$query = "SELECT FIRST_NAME, LAST_NAME FROM employee WHERE EMPLOYEE_ID = '{$emp_id}'";
$result = mysqli_query($db, $query);
$names = mysqli_fetch_assoc($result);
$fullName = $names["FIRST_NAME"] . $names["LAST_NAME"];
$newFullName = "";

for ($i=0; $i < strlen($fullName); $i++) { 
    # code...
    if ($fullName[$i] === " ") {
        $newFullName[$i] = rand(0, 9);
    } else {
        $newFullName[$i] = $fullName[$i];
    }
}

$path = "../img/qrcode/";
$qrcode = $path.date("Y-m-d H,i,s") . ".png";
$completeDetails = $newFullName . generateRandomString();
echo $qrcode . "<br>";
echo $completeDetails;

QRcode::png($completeDetails, $qrcode, "H", 4, 4);

$updateQuery = "UPDATE employee SET QR_CODE_TEXT = '{$completeDetails}', QR_CODE_IMG_PATH = '{$qrcode}' WHERE EMPLOYEE_ID = '{$emp_id}'";
mysqli_query($db, $updateQuery);

header("location: emp_searchfrm.php?action=edit & id='{$emp_id}'");
