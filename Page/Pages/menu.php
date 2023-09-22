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
    <style>

        /* Style for the parent div */
        .card-body {
            position: relative; /* Required for positioning the button */
        }
        /* Style for the button */
        button {
            width: 30%; /* Set the button to be half the width of the parent */
            position: absolute; /* Position it absolutely within the parent */
            bottom: 5px; /* Margin from the bottom */
            right: 5px; /* Margin from the right */
            opacity: 50%;
        }
        .custom-btn-size {
            font-size: 10px;  
        }
        hr {
          margin: 0rem;
          color: grey;
          opacity: 0.25;
        }
    </style>

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


<script>

document.addEventListener("DOMContentLoaded", function() {



  document.getElementById("btn").addEventListener("click", function() {


    let file = "http://localhost:8000/test.php"

  fetch (file).then((response) => response.json()).then(json => alert(json.Test));

     //let tmpObj =JSON.parse(x);

     //alert(tmpObj.test);

  

  });

})

</script>