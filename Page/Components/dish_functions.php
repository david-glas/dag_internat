<?php
include "../Database/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (array_key_exists('foodID_input', $_POST)) { $food_id = $_POST['foodID_input']; }
  if (array_key_exists('foodName_input', $_POST)) { $food_name = $_POST['foodName_input']; }
  if (array_key_exists('breakfast', $_POST)) { $breakfast = $_POST['breakfast']; }
  if (array_key_exists('starter', $_POST)) { $starter = $_POST['starter']; }
  if (array_key_exists('lunch', $_POST)) { $lunch = $_POST['lunch']; }
  if (array_key_exists('dessert', $_POST)) { $dessert = $_POST['dessert']; }
  if (array_key_exists('dinner', $_POST)) { $dinner = $_POST['dinner']; }
  if (array_key_exists('action', $_POST)) { $action = $_POST['action']; }
  
  $meal_ids = array();

  if (isset($breakfast)) { $meal_ids[] = '1'; }
  if (isset($starter)) { $meal_ids[] = '2'; }
  if (isset($lunch)) { $meal_ids[] = '3'; $meal_ids[] = '4'; }
  if (isset($dessert)) { $meal_ids[] = '5'; }
  if (isset($dinner)) { $meal_ids[] = '6'; $meal_ids[] = '7'; }

  $foodCon = new Food();
  if ($action == 'create') {
    $foodCon->AddFood($food_name, $meal_ids);
  }
  else if ($action == 'change') {
    $foodCon->UpdateFood($food_id, $food_name, $meal_ids);
  }
  else if ($action == 'delete') {
    $foodCon->DeleteFood($food_id);
  }
}
  header("Location: ../index.php?page=dashboard&subpage=dishes");
?>