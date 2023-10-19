<style>
  .nav-pills .nav-link.active,.nav-pills .show>.nav-link {
    color: #fff;
    background-color: #858585;
    border: none;
  }
  /* Komische Kasterl bei den Reitern entfernen mit flex-grow auf 0*/
  .navbar-collapse {
    flex-basis: 100%;
    flex-grow: 0;
    align-items: center;
  }
  /* Hintergrundfarbe und Höhe der Navbar*/
  .navbar{
    background: rgb(52, 53, 65);
    /*background: linear-gradient(0deg, rgba(63,62,68,0.94) 0%, rgba(63,62,68,0.92) 48%, rgba(63,62,68,0.8830705705705706) 94%);*/
    height: 84px;
  }

  /* Weißer Text für Links und Überschrift */
  .navbar-nav .nav-link,
  .navbar-brand {
    color: #fff; /* Weißer Text */
  }

  /* Orange Text für aktive Links */
  .navbar-nav .nav-link.active,
  .navbar-nav .nav-link.show,
  .navbar-brand.active {
    color: rgba(240, 206, 93, 0.793); /* Orange Text für aktive Links */
    background-color: transparent; /* Transparentes Hervorhebungsfeld */
    box-shadow: none; /* Kein Schatten */
  }
  .navbar-brand {
    color: #fff; /* Schriftfarbe */
    font-size: 24px; /* Schriftgröße */
    font-weight: bold; /* Fetter Text */
    font-family: 'Arial', sans-serif; /* Schriftart, ersetzen Sie 'Arial' durch die gewünschte Schriftart */ 
  }
  .navbar-toggler{
    margin-right: 5px;
  }
  @media (max-width: 768px) {
  .navbar-collapse{
    background: rgb(52, 53, 65);
    /*background: linear-gradient(0deg, rgba(63,62,68,0.94) 0%, rgba(63,62,68,0.92) 48%, rgba(63,62,68,0.8830705705705706) 94%);*/
    box-shadow: 100px;
  }
  .navbar>.container{
    padding: 0px;
  }
  }
</style>

<nav class="navbar sticky-top nav-pills navbar-expand-md">
  <div class="container">
    <a class="navbar-brand" href="?page=landing">
      <img class="me-3" src="assets\img\DAG72.png" alt="Dagobert DAG">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07"
      aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarsExample07">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex justify-content-end">
        <?php 
        if ($_SESSION["user"]["account"] != "webuser") {
          echo
          '<li class="nav-item mx-3">
            <a class="nav-link btn-secondary'. setActive('menu') .'" href="?page=menu">Menü</a>
          </li>';

          if (in_array($_SESSION["user"]["account"], array("Admin", "Kantine"))) {
            echo
            '<li class="nav-item mx-3">
              <a class="nav-link'. setActive('dashboard') .'" href="?page=dashboard">Dashboard</a>
            </li>';
          }

          if (in_array($_SESSION["user"]["account"], array("Schüler"))) {
            echo
            '<li class="nav-item mx-3">
              <a class="nav-link" id="qrnav">QR</a>
            </li>';
          }
        }
        ?>
        <li class="nav-item mx-3">
          <a class="<?php echo 'nav-link'. setActive('instructions') ?>" href="?page=instructions">Handbuch</a>
        </li>
        <li class="nav-item mx-3">
          <a class="<?php echo 'nav-link'. setActive('about') ?>" href="?page=about">Über uns</a>
        </li>
        <?php
        if ($_SESSION["user"]["account"] != "webuser") {
          echo
          '<form action="Components/logout.php">
            <button type="submit" class="btn btn-warning mx-3 btn-sm p-2">
              <i class="bi bi-door-closed-fill"></i> Abmelden
            </button>
            </form>';
        }
        else {
          echo
          '<button type="button" class="btn btn-warning mx-3 btn-sm p-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="bi bi-person-fill"></i> Anmelden
          </button>';
        }
        ?>
        
      </ul>
    </div>
  </div>
</nav>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content rounded-4 shadow">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Anmelden</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-5 pt-0">
        <form method="POST" action="Components/login.php">
          <div class="form-floating mb-3">
            <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="0000000000" name="svnr">
            <label for="floatingInput">SV-Nummer</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control rounded-3" id="floatingPassword" placeholder="Password" name="password">
            <label for="floatingPassword">Passwort</label>
          </div>
          <button class="w-100 mb-2 btn btn-lg rounded-3 btn-secondary" type="submit">Anmelden</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php function setActive($page)
{
  if (isset($_GET['page'])) {
    if ($_GET['page'] == $page) {
      return " active";
    }
  }
}
?>

<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">QR Code</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body mt-3 mb-3">
      <div id="qrcode" hidden style="  text-align: center;
                                        display: flex;
                                        flex-direction: column;
                                        justify-content: center;
                                        align-items: center;
                                        height: 100%;">
      </div>
      <div id="qrtext" hidden></div>
      </div>
    </div>
  </div>
</div>

<script src="Components/qr.js"></script>