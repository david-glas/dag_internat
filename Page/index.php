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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <!-- Swiper -->
  <script src="assets/Swiper/swiper-bundle.min.js"></script>
  <link rel="stylesheet" type="text/css" href="assets/Swiper/swiper-bundle.min.css">

  <!-- Navbar -->
  <link href="assets/css/navbars.css" rel="stylesheet">

  <title>Document</title>
</head>
<?php
if (($_SESSION["user"]["account"] != "webuser")) {

}

include "Components/nav.php";

?>

<body>
  <?php
  if (isset($_GET['page'])) {
    switch ($_GET['page']) {
      case 'dashboard':
        if (in_array($_SESSION["user"]["account"], array("admin", "cantine"))) { include "Pages/dashboard.php"; }
        else { echo '<div class="container"><h1>Nice try Hackerman!</h1></div>'; }
        break;
      case 'menu':
        if ($_SESSION["user"]["account"] != "webuser") { include "Pages/menu.php"; }
        else { echo '<div class="container"><h1>Nice try Hackerman!</h1></div>'; }
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