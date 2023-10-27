<?php
include "../Database/conn.php";

$test = $_POST;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (array_key_exists("action", $_POST)) {
    if (array_key_exists('userID_input', $_POST)) { $user_id = $_POST['userID_input']; }
    $firstname = $_POST['firstname_input'];
    $lastname = $_POST['lastname_input'];
    $svnr = $_POST['svnr_input'];
    $role_id = $_POST['role_select'];
    $class_id = $_POST['class_select'];
    $action = $_POST['action'];
    $password_change = false;
    $password = "";

    if ($class_id == -1) {
      $class_id = null;
    }

    if (isset($_POST['password_change'])) {
      $password = $_POST['password_input'];
      $password_change = true;
    }

    $user = new User();
    if ($action == 'create') {
      $user->AddUser($svnr, $firstname, $lastname, $password, $role_id, $class_id);
    }
    else if ($action == 'change') {
      $user->UpdateUser($user_id, $svnr, $firstname, $lastname, $password, $password_change, $role_id, $class_id);
    }
    else if ($action == 'delete') {
      $user->DeleteUser($user_id);
    }
  }
  else if (array_key_exists("delete", $_POST)) {
    $user = new User();
    $user->DeleteClass($_POST['delete']);
  }
  else if (array_key_exists("add", $_POST)) {
    $user = new User();
    $user->AddClass($_POST['class_name']);
  }
}
  header("Location: ../index.php?page=dashboard&subpage=users");
?>