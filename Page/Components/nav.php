<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
  <div class="container-fluid">
    <a class="navbar-brand" href="?page=home" style="background-color: transparent">Einfach Essen</a>
    <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?php setActive('menu') ?>" href="?page=menu">Menu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php setActive('dashboard') ?>" href="?page=dashboard">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php setActive('instructions') ?>" href="?page=instructions">Instructions</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php function setActive($page) {
  if(isset($_GET['page'])) {
    if($_GET['page'] == $page) {
      echo "active";
    } 
  }
}