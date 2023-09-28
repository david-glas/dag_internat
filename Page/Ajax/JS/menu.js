document.addEventListener('DOMContentLoaded', function () {

  fetch('Components/getUser.php')
  .then(response => response.text())
  .then(data => {
      updateTabs(data);
  })
  .catch(error => {
      console.error('Error:', error);
  });
});

function updateButtons() {
  const buttons = document.querySelectorAll('[name="userbutton"]');

  buttons.forEach(function (button, index) {
    button.addEventListener('click', function () {
      const menuId = button.getAttribute('data-menu-id');
      const userId = button.getAttribute('data-user-id');
      const mealId = button.getAttribute('data-meal-id');
      const url = 'Database/MenuHandling.php';
      var method;

      if (button.classList.contains('btn-success')) {
        button.classList.remove('btn-success');
        button.classList.add('btn-danger');
        button.innerHTML = 'Abmelden';
        method = 'addUserToMenu';
        resetOtherMeal(parseInt(menuId), userId, mealId);
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

  const items = document.querySelectorAll('.dropdown-item');

  items.forEach(function (item, index) {
    item.addEventListener('click', function () {

      const menuId = item.getAttribute('data-menu-id');
      const foodId = item.getAttribute('data-food-id');
      const url = 'Database/MenuHandling.php';
      const method = 'addFoodToMenu';


      const requestData = {
        method: method,
        menuId: menuId,
        foodId: foodId
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
          var text = document.getElementById('Menu' + menuId);
          text.innerHTML = data["result"];
        })
        .catch(error => {
          console.error('Fehler beim Abrufen der Daten:', error);
        });
    });
  });

  const adds = document.querySelectorAll('[name="addday"]');

  adds.forEach(function (add, index) {
    add.addEventListener('click', function () {

      const day = add.getAttribute('data-date');
      const url = 'Database/MenuHandling.php';
      const method = 'addMenuDay';


      const requestData = {
        method: method,
        day: day,
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

};

function updateTabs(user){
  
  var spinner = document.getElementById("spinner");
  spinner.style.display = "none";
  const tabs = document.querySelectorAll('a');
  var user;

  tabs.forEach(function (tab, index) {
    tab.addEventListener('click', function () {
      var spinner = document.getElementById("spinner");
      spinner.style.display = "block";
      const url = 'Components/MenuCard.php';
      var method = 'getCardsByWeek';
      if (user == "admin") {
        method = 'getCardsByWeekAdmin';
      }
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
          updateButtons();
        })
        .catch(error => {
          console.error('Fehler beim Abrufen der Daten:', error);
        });
    })
    if (tab.getAttribute("id") == 0) {
      tab.click();
    }
  })
}

function resetOtherMeal(menuId, userId, mealId){
  var otherMenu;
  if (mealId == 3 || mealId == 6){
    otherMenu = menuId + 1;
  } else if (mealId == 4 || mealId == 7){
    otherMenu = menuId - 1;
  } 

  if (otherMenu){
    button = document.querySelector(`button[data-menu-id="${otherMenu}"]`);
    if (button.innerHTML == "Abmelden"){
      button.click();
    }
  }
}