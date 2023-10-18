<?php
include "../Database/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $action = "";
  $values = "";
  $set_time = false;

  if (isset($_POST['delete'])) {
    $action = 'delete';
    $values = $_POST['delete'];
  }
  else if (isset($_POST['add'])) {
    $action = 'add';
    $values = $_POST['add'];
    if(isset($_POST['set_time'])) { $set_time = true; }
  }

  list($user_id, $menu_id) = explode('_', $values);

  $menu = new Menu();
  if ($action == 'add' && $user_id != -1) {
    $menu->AddUserToMenu($menu_id, $user_id, $set_time);
  }
  else if ($action == 'delete') {
    $menu->RemoveUserFromMenu($menu_id, $user_id);
  }
}

  header("Location: ../index.php?page=dashboard");
?>