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
    background: rgb(63,62,68);
    background: linear-gradient(0deg, rgba(63,62,68,0.94) 0%, rgba(63,62,68,0.92) 48%, rgba(63,62,68,0.8830705705705706) 94%);
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
  @media (max-width: 768px) {
  .navbar-collapse{
    background: rgb(63,62,68);
    background: linear-gradient(0deg, rgba(63,62,68,0.94) 0%, rgba(63,62,68,0.92) 48%, rgba(63,62,68,0.8830705705705706) 94%);
    box-shadow: 100px;
  }
  .navbar>.container{
    padding: 0px;
  }
  }
</style>



<nav class="navbar sticky-top nav-pills navbar-expand-md">
  <div class="container">
    <a class="navbar-brand" href="?page=landing" style="background-color: transparent">DAG GmbH</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07"
      aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarsExample07">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex justify-content-end">
        <?php 
        if ($_SESSION["user"]["account"] != "webuser") {
          echo
          '<li class="nav-item">
            <a class="nav-link btn-secondary'. setActive('menu') .'" href="?page=menu">Menu</a>
          </li>';

          if (in_array($_SESSION["user"]["account"], array("admin", "cantine"))) {
            echo
            '<li class="nav-item">
              <a class="nav-link'. setActive('dashboard') .'" href="?page=dashboard">Dashboard</a>
            </li>';
          }
        }
        ?>
        <li class="nav-item">
          <a class="<?php echo 'nav-link'. setActive('instructions') ?>" href="?page=instructions">Instructions</a>
        </li>
        <li class="nav-item">
          <a class="<?php echo 'nav-link'. setActive('about') ?>" href="?page=about">About</a>
        </li>
        <?php
        if ($_SESSION["user"]["account"] != "webuser") {
          echo
          '<li class="nav-item">
            <a class="nav-link" href="Components/logout.php">Logout</a>
          </li>';
        }
        else {
          echo
          '<li class="nav-item">
            <a class="nav-link" href="index.php">Login</a>
          </li>';
        }
        ?>
      </ul>
    </div>
  </div>
</nav>



<?php function setActive($page)
{
  if (isset($_GET['page'])) {
    if ($_GET['page'] == $page) {
      return " active";
    }
  }
}