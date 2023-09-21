<?php
include "Database/conn.php";
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap 5 -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- Elements -->
  <link href="assets/css/dashboard.css" rel="stylesheet">
  <link href="assets/css/offcanvas-navbar.css" rel="stylesheet">
  <script src="assets/js/dashboard.js"></script>
  <script src="assets/js/offcanvas-navbar.js"></script>

  <title>Document</title>
</head>
<?php
  include "Components/nav.php";
?>
<body>
<?php
  if(isset($_GET['page']))
  {
    switch($_GET['page'])
    {
      case 'dashboard':
        include "Pages/dashboard.php";
        break;
      case 'menu':
        include "Pages/menu.php";
      default:
      include "Pages/landing.php";
    }
  } else { include "Pages/landing.php"; }
  include "Components/footer.php";
?>
  
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