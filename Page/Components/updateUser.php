<?php
include "../Database/conn.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $requestData = json_decode(file_get_contents('php://input'));
  $userId = $_SESSION["user"]["userid"];
  $pw = $requestData->pw;

  $user = new User();
  $result = $user->VerifyUser($userId, $pw, 3);
  $jsonData = json_encode(array('result' => (string)$result));
  $_SESSION["user"]["account"] ="Schüler";
  echo $jsonData;
};
?>