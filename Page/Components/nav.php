<style>
  .nav-pills .nav-link.active,
  .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #858585;
  }
  .navbar-collapse {
    flex-basis: 100%;
    flex-grow: 0;
    align-items: center;
  }
  .navbar{
    background-color: rgba(42, 42, 40, 0.92);
    height: 78px;
  }
</style>

<nav class="navbar sticky-top nav-pills navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="?page=landing" style="background-color: transparent">Test Title</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07"
      aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarsExample07">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex justify-content-end">
        <li class="nav-item">
          <a class="nav-link btn-secondary <?php setActive('menu') ?>" href="?page=menu">Menu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php setActive('dashboard') ?>" href="?page=dashboard">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php setActive('instructions') ?>" href="?page=instructions">Instructions</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php setActive('about') ?>" href="?page=about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Components/logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php function setActive($page)
{
  if (isset($_GET['page'])) {
    if ($_GET['page'] == $page) {
      echo "active";
    }
  }
}