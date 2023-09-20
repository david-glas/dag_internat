<?php
include "Database/conn.php";
?>
<!DOCTYPE html>
<html lang="en">
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
      default:
      include "Pages/landing.php";
    }
  } else { include "Pages/landing.php"; }
?>
  
</body>
</html>