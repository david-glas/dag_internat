<?php
include "../Database/conn.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $svnr = $_POST["svnr"];
    $password = $_POST["password"];

    $User = new User();
    $result = $User->CheckLogin($svnr, $password);
    // Perform validation (you can add more validation as needed)
    if ($result != "webuser") {
        // Validation successful
        // Set the user data in $_SESSION
        $_SESSION["user"] = [
            "account" => $result["name"],
            "userid" => $result["userid"]
            // You can add more user data here
        ];

        // Redirect to a protected page or dashboard
        header("Location: ../index.php?page=menu");
        exit();
    } else {
        header("Location: ../index.php");
    }
}
?>