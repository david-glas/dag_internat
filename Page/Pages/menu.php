<?php

include "Components/MenuCard.php";

function IsActive($tab, $week)
{
  if ($tab == $week) {
    return "active";
  } else {
    return "";
  }
}

$week = intval($_GET['week']);

?>
<style>
  /* Style for the parent div */
  .card-body {
    position: relative;
    height: 150px;
    /* Required for positioning the button */
  }

  /* Style for the button */
  button {
    width: 30%;
    /* Set the button to be half the width of the parent */
    position: absolute;
    /* Position it absolutely within the parent */

    bottom: 5px;
    /* Margin from the bottom */
    right: 5px;
    /* Margin from the right */
    opacity: 50%;
    width: 40%;
  }

  .custom-btn-size {
    font-size: 10px;
  }

  hr {
    margin: 0rem;
    color: grey;
    opacity: 0.25;
  }

  .card-text {
    padding-bottom: 15px;
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
  document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('button');

    buttons.forEach(function (button, index) {
      button.addEventListener('click', function () {


        const menuId = button.getAttribute('data-menu-id');
        const userId = button.getAttribute('data-user-id');
        const url = 'Database/MenuHandling.php';
        var method

        if (button.classList.contains('btn-success')) {
          button.classList.remove('btn-success');
          button.classList.add('btn-danger');
          button.innerHTML = 'Abmelden';
          method = 'addUserToMenu';
        }
        else {
          button.classList.remove('btn-danger');
          button.classList.add('btn-success');
          button.innerHTML = 'Anmelden';
          method = 'removeUserFromMenu';
        }

        const requestData = {
          method: method,
          menuId: menuId,
          userId: userId
        };

        fetch(url, {
          method: 'POST',
          body: JSON.stringify(requestData),
          headers: {
            'Content-Type': 'application/json'
          }
        })
          .then(response => response.json())
          .then(data => {
          })
          .catch(error => {
            console.error('Fehler beim Abrufen der Daten:', error);
          });
      });
    });
  });

</script>