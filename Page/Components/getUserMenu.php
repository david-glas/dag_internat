<?php
include "../Database/conn.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $requestData = json_decode(file_get_contents('php://input'));
    // Retrieve form data
    $userid = $requestData->userid;
    $tod = $requestData->tod;
    $date = $requestData->date;

    $User = new User();
    $result = $User->GetUserMenu($userid, $tod, $date);
    $result = json_encode($result);

    echo $result;
}
?>