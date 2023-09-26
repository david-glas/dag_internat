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
      <a id="0" class="nav-link" style="color: #565656">Aktuelle
        Woche</a>
    </li>
    <li class="nav-item">
      <a id="1" class="nav-link" style="color: #565656">Nächste
        Woche</a>
    </li>
    <li class="nav-item">
      <a id="2" class="nav-link" style="color: #565656">Übernächste
        Woche</a>
    </li>
    <li id="spinner" class="nav-item">
      <div class="spinner-border text-secondary" role="status">
      </div>
    </li>
  </ul>
  <br>
  <div id="card-container" class="row row-cols-1 row-cols-md-5 g-4">
  </div>
</div>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    var spinner = document.getElementById("spinner");
    spinner.style.display = "none";
    const tabs = document.querySelectorAll('a');
    tabs.forEach(function (tab, index) {
      tab.addEventListener('click', function () {
        var spinner = document.getElementById("spinner");
        spinner.style.display = "block";
        const url = 'Components/MenuCard.php';
        const method = 'getCardsByWeek';
        const requestData = {
          method: method,
          week: tab.getAttribute("id")
        };


        fetch(url, {
          method: 'POST',
          body: JSON.stringify(requestData),
          headers: {
            'Content-Type': 'application/json'
          }
        })
          .then(response => response.text())
          .then(data => {
            var container = document.getElementById("card-container");
            container.innerHTML = data;
            var spinner = document.getElementById("spinner");
            spinner.style.display = "none";
          })
          .catch(error => {
            console.error('Fehler beim Abrufen der Daten:', error);
          });
      })
    });


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