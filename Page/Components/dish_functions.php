<?php
include "../Database/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $test = $_POST;
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
    $user->UpdateUser($svnr, $firstname, $lastname, $password, $role_id);
  }
  else if ($action == 'delete') {
    $user->DeleteUser($svnr);
  }
}
  header("Location: ../index.php?page=dashboard&subpage=dishes");
?>