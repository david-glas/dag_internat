<?php
 include "Database/conn.php"; 
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="bright">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap 5 -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- Navbar -->
  <link href="assets/css/navbars.css" rel="stylesheet">

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
        break;
      default:
        include "Pages/landing.php";
        break;
    }
  } else { include "Pages/landing.php"; }
  include "Components/footer.php";
?>
  
</body>
</html>