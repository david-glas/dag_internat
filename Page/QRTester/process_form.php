<?php
  $encrypt_method = "AES-256-CBC";
  $secret_key = 'xxxxxxxxxxxxxxxxxxxxxxxx';
  $secret_iv = 'xxxxxxxxxxxxxxxxxxxxxxxxx';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST["userId"];
    $date = $_POST["date"];
    $tod = $_POST["tod"];
    $name = $_POST["name"];
    $data = '{"userid":"' . $userId . '","name":"' . $name . '","tod":"' . $tod . '","date":"' . $date . '"}';

    // Hash the secret key
    $key = hash('sha256', $secret_key);
    // Generate an initialization vector (IV)
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    // Encrypt the data
    $output = openssl_encrypt($data, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
    echo $output;
}
?>