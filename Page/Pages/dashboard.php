<style>
  .nav-scroller .nav {
    color: rgba(255, 255, 255, .75);
  }
  .nav-scroller {
    margin-bottom: 20px;
  }

  .nav-scroller .nav-link {
    padding-top: .75rem;
    padding-bottom: .75rem;
    font-size: .875rem;
    color: #6c757d;
  }

  .nav-scroller .nav-link:hover {
    color: #007bff;
  }

  .nav-scroller .active {
    font-weight: 500;
    color: #343a40;
  }
</style>

<div class="container">
<div class="nav-scroller bg-body shadow-sm">
  <nav class="nav" aria-label="Secondary navigation">
    <a class="nav-link <?php setActiveSub('overview') ?>" href="?page=dashboard&subpage=overview">Übersicht</a>
    <a class="nav-link <?php setActiveSub('scan') ?>" href="?page=dashboard&subpage=scan">Scan</a>
    <a class="nav-link <?php setActiveSub('users') ?>" href="?page=dashboard&subpage=users">Benutzer</a>  
    <a class="nav-link <?php setActiveSub('dishes') ?>" href="?page=dashboard&subpage=dishes">Gerichte</a>
  </nav>
</div>
</div>

<?php
  if (isset($_GET['subpage'])) {
    switch ($_GET['subpage']) {
      case 'users':
        include "Pages/users.php";
        break;
      case 'dishes':
        include "Pages/dishes.php";
        break;
      case 'scan':
        include "Pages/scan.php";
        break;
      case 'overview':
        include "Pages/overview.php";
        break;
      default:
        include "Pages/overview.php";
        break;
    }
  } else {
    include "Pages/overview.php";
  }
  function setActiveSub($subpage)
  {
    if (isset($_GET['subpage'])) {
      if ($_GET['subpage'] == $subpage) {
        echo "active";
      }
    }
    else if ($subpage == 'overview') {
      echo "active";
    }
  }