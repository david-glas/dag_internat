<?php
include "Database/conn.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap 5 -->
  <!-- Latest compiled and minified CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Latest compiled JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <title>Document</title>
</head>
<?php
  include "Components/header.php";
?>
<body>
  
</body>
</html>

<?php
$user = new User();
$food = new Food();
$menu = new Menu();

$date = date('2023-09-18');
$menu->AddOrUpdMenuEntry(2, 2, $date);

#$user->UpdateUser("0205965818", "Horst", "Geberle", "saufen", 2);
#$result = $user->CheckLogin("0205965818", "saufen");
#$result = $food->AddFood("Chicken", array(2, 2));
#echo $result;
?>