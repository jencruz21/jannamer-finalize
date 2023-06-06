<?php

require('../includes/connection.php');
require('session.php');
if (isset($_POST['qr_text'])) {


  $qr_text = $_POST['qr_text'];
//create some sql statement             
$sql = "SELECT ID,e.FIRST_NAME,e.LAST_NAME,e.GENDER,e.EMAIL,e.PHONE_NUMBER,j.JOB_TITLE,l.PROVINCE,l.CITY,t.TYPE, u.POSITION_ID, e.QR_CODE_TEXT 
FROM  `users` u
join `employee` e on e.EMPLOYEE_ID=u.EMPLOYEE_ID
JOIN `location` l ON e.LOCATION_ID=l.LOCATION_ID
join `job` j on u.POSITION_ID=j.JOB_ID
join `type` t ON t.TYPE_ID=u.TYPE_ID
WHERE e.QR_CODE_TEXT = '$qr_text'";
$result = $db->query($sql);

    if ($result) {
        //get the number of results based n the sql statement
        //check the number of result, if equal to one   
        //IF theres a result
        //store the result to a array and passed to variable found_user
        $found_user  = mysqli_fetch_array($result);
        //fill the result to session variable
        $_SESSION['MEMBER_ID']  = $found_user['ID']; 
        $_SESSION['FIRST_NAME'] = $found_user['FIRST_NAME']; 
        $_SESSION['LAST_NAME']  =  $found_user['LAST_NAME'];  
        $_SESSION['GENDER']  =  $found_user['GENDER'];
        $_SESSION['EMAIL']  =  $found_user['EMAIL'];
        $_SESSION['PHONE_NUMBER']  =  $found_user['PHONE_NUMBER'];
        $_SESSION['JOB_TITLE']  =  $found_user['JOB_TITLE'];
        $_SESSION['PROVINCE']  =  $found_user['PROVINCE']; 
        $_SESSION['CITY']  =  $found_user['CITY']; 
        $_SESSION['TYPE']  =  $found_user['TYPE'];
        $_SESSION['POSITION_ID'] = $found_user['POSITION_ID'];
        $AAA = $_SESSION['MEMBER_ID'];

        //this part is the verification if admin or user ka
        if ($_SESSION['TYPE']=='Admin') {        
            echo "Login successful! Welcome " . $_SESSION['FIRST_NAME'];
        } elseif ($_SESSION['TYPE']=='User') {
            echo "Login successful! Welcome " . $_SESSION['FIRST_NAME'];
        }
    } else {
        echo "Error: " . $sql . $db->error;
    }    
} 
 $db->close();
?>