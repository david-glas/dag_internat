<?php
include "../Database/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (array_key_exists('userID_input', $_POST)) { $user_id = $_POST['userID_input']; }
  $firstname = $_POST['firstname_input'];
  $lastname = $_POST['lastname_input'];
  $svnr = $_POST['svnr_input'];
  $password = $_POST['password_input'];
  $role_id = $_POST['role_select'];
  $action = $_POST['action'];

  $user = new User();
  if ($action == 'create') {
    $user->AddUser($svnr, $firstname, $lastname, $password, $role_id);
  }
  else if ($action == 'change') {
    $user->UpdateUser($user_id, $svnr, $firstname, $lastname, $password, $role_id);
  }
  else if ($action == 'delete') {
    $user->DeleteUser($user_id);
  }
}

  header("Location: ../index.php?page=dashboard&subpage=users");
?>