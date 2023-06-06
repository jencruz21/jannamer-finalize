<?php
include '../includes/connection.php';
require_once "../phpqrcode/qrlib.php";
?>

<?php

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

$fname = mysqli_real_escape_string($db, $_POST['firstname']);
$mname = mysqli_real_escape_string($db, $_POST['middlename']);
$lname = mysqli_real_escape_string($db, $_POST['lastname']);
$gen = mysqli_real_escape_string($db, $_POST['gender']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$phone = mysqli_real_escape_string($db, $_POST['phonenumber']);
$jobb = mysqli_real_escape_string($db, $_POST['jobs']);
$hdate = mysqli_real_escape_string($db, $_POST['hireddate']);
$prov = mysqli_real_escape_string($db, $_POST['province']);
$cit = mysqli_real_escape_string($db, $_POST['city']);
$completeDetails = $fname . $lname . generateRandomString();
$path = "../img/qrcode/";
$qrcode = $path.date("Y-m-d H,i,s") . ".png";
$qrcode = mysqli_real_escape_string($db, $qrcode);

$result = mysqli_query($db, "SELECT MAX(LOCATION_ID) AS LOCATION_ID FROM location");
$location_id = mysqli_fetch_assoc($result);
$locid = (int)$location_id["LOCATION_ID"];

QRcode::png($completeDetails, $qrcode, "H", 4, 4);
mysqli_query($db, "INSERT INTO location
                              (PROVINCE, CITY)
                              VALUES ('$prov','$cit')");
$employeeQuery = "INSERT INTO employee 
    (
    FIRST_NAME,
    MIDDLE_NAME, 
    LAST_NAME, 
    GENDER, 
    EMAIL, 
    PHONE_NUMBER, 
    JOB_ID, 
    HIRED_DATE,
    QR_CODE_TEXT, 
    QR_CODE_IMG_PATH, 
    LOCATION_ID
    )
VALUES 
    (
    '$fname',
    '{$mname}',
    '$lname',
    '$gen',
    '$email',
    '$phone',
    '$jobb',
    '$hdate', 
    '$completeDetails', 
    '$qrcode', 
    '$locid'
    )";

$res = mysqli_query($db, $employeeQuery) or die(mysqli_error($db));
echo $res;
header('location:employee.php');
?>