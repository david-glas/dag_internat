<?php
include "Database/conn.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DAG</title>

  <!-- Bootstrap 5 -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <!-- Chart -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

  <!-- Swiper -->
  <script src="assets/Swiper/swiper-bundle.min.js"></script>
  <link rel="stylesheet" type="text/css" href="assets/Swiper/swiper-bundle.min.css">

  <!-- Navbar -->
  <link href="assets/css/navbars.css" rel="stylesheet">

  <!-- Scan -->
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

  <!-- QR -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

  <title>Document</title>
  <link rel="icon" type="image/x-icon" href="assets/img/DAG72.png">
</head>

<?php
include "Components/nav.php";
?>

<body>
  <?php
  if (isset($_SESSION['login_failed']) && $_SESSION['login_failed'] == 'yes') {
    drawAlert();
    $_SESSION['login_failed'] = 'no';
  }
  if (isset($_GET['page'])) {
    switch ($_GET['page']) {
      case 'dashboard':
        if (in_array($_SESSION["user"]["account"], array("Admin", "Kantine"))) {
          include "Pages/dashboard.php";
        } else {
          echo '<div class="container"><h1>Nice try Hackerman!</h1></div>';
        }
        break;
      case 'menu':
        if ($_SESSION["user"]["account"] != "webuser") {
          include "Pages/menu.php";
          include "Components/Modal.php";
        } else {
          echo '<div class="container"><h1>Nice try Hackerman!</h1></div>';
        }
        break;
      case 'about':
        include "Pages/about.php";
        break;
      case 'instructions':
        include "Pages/instructions.php";
        break;
      default:
        include "Pages/landing.php";
        break;
    }
  } else {
    include "Pages/landing.php";
  }
  include "Components/footer.php";
  ?>
</body>

</html>

<?php

function drawAlert() {
  echo
  '<div class="container">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Login fehlgeschlagen!</strong> Überprüfen Sie bitte Ihre Eingaben.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>';
}