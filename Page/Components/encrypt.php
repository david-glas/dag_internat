<?php
include "../Database/conn.php";
$userId = $_SESSION["user"]["userid"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $requestData = json_decode(file_get_contents('php://input'));
  // Retrieve form data
  $action = $requestData->action;

  if ($action == "encrypt") {
    $tod = $requestData->tod;
    $date = $requestData->day;
    $name = (new User())->GetUserNameById($userId);
    $text = '{"userid":"' . $userId . '","name":"' . $name . '","tod":"' . $tod . '","date":"' . $date . '"}';

    $test = encrypt_decrypt($action, $text);

    echo $test;
  } else if ($action == "decrypt") {
    $text = $requestData->text;
    $test = encrypt_decrypt($action, $text);
    //$json = json_encode($test);
    echo $test;
  }
}


function encrypt_decrypt($action, $string)
{
  $output = false;
  $encrypt_method = "AES-256-CBC";
  $secret_key = 'xxxxxxxxxxxxxxxxxxxxxxxx';
  $secret_iv = 'xxxxxxxxxxxxxxxxxxxxxxxxx';
  // hash
  $key = hash('sha256', $secret_key);
  // iv - encrypt method AES-256-CBC expects 16 bytes 
  $iv = substr(hash('sha256', $secret_iv), 0, 16);
  if ($action == 'encrypt') {
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
  } else if ($action == 'decrypt') {
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
  }
  return $output;
}

?>