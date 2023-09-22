<?php

include "Components/MenuCard.php";

function IsActive($tab, $week){
  if ($tab == $week){
    return "active";
  }
  else{
    return "";
  }
}

$week = intval($_GET['week']);

?>

<div class="container">
<ul class="nav nav-pills card-header-pills">
      <li class="nav-item">
        <a class="nav-link <?php IsActive(0, $week) ?>" href="?page=menu&week=0" style="color: #565656">Today</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php IsActive(0, $week) ?>" href="?page=menu&week=1" style="color: #565656">Next Week</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php IsActive(0, $week) ?>" href="?page=menu&week=2" style="color: #565656">Next Next Week</a>
      </li>
    </ul>
    <br>
  <div class="row row-cols-1 row-cols-md-5 g-4">

   <?php
    echo GetCardsByWeek($week);
   ?>
  </div>
</div>
