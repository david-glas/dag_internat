document.addEventListener('DOMContentLoaded', function () {



  fetch('Components/getUser.php')
    .then(response => response.text())
    .then(data => {
      updateTabs(data);
      if (data == "Schüler (ohne Passwort)") {
        getModal();
      }
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

      var card = document.getElementById(menuId);
      var ordered = card.getAttribute('data-ordered');
      if (ordered == "1") {
        card.style.backgroundColor = "transparent";
        card.setAttribute('data-ordered', "0");
        method = 'removeUserFromMenu';

      } else {
        card.style.backgroundColor = "rgba(154, 211, 154, 0.51)";
        card.setAttribute('data-ordered', "1");
        method = 'addUserToMenu';
        resetOtherMeal(parseInt(menuId), userId, mealId);
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
      var foodId = item.getAttribute('data-food-id');
      const url = 'Database/MenuHandling.php';
      const method = 'addFoodToMenu';

      if (foodId == "") {
        foodId = null;
      }

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

function updateTabs(user) {
  const tabs = document.querySelectorAll('[name="Week"]');
  tabs.forEach(function (tab, index) {
    tab.addEventListener('click', function () {

      const url = 'Components/MenuCard.php';
      var method = 'getCardsByWeek';
      if (user == "Admin" || user == "Kantine") {
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
          updateButtons();
          updateSwiper();
          
          tabs.forEach(element => {
            element.classList.remove("active");
          });
          tab.classList.add("active");
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

function resetOtherMeal(menuId, userId, mealId) {
  var otherMenu;
  if (mealId == 3 || mealId == 6) {
    otherMenu = menuId + 1;
  } else if (mealId == 4 || mealId == 7) {
    otherMenu = menuId - 1;
  }

  if (otherMenu) {
    var card = document.getElementById(otherMenu);
    var ordered = card.getAttribute('data-ordered');
    if (ordered == "1") {
      var button = document.querySelector(`[data-menu-id="${otherMenu}"]`);
      button.click();
    }
  }
}

function updateSwiper() {
  const swiper = new Swiper('.swiper', {
    slidesPerView: 1,
    spaceBetween: 25,
    initialSlide: (new Date()).getDay() - 1,
    breakpoints: {
      0: {
        slidesPerView: 1,
      },
      520: {
        slidesPerView: 2,
      },
      950: {
        slidesPerView: 3,
      },
      1200: {
        slidesPerView: 4,
      },
      1400: {
        slidesPerView: 5,
      }
    },
    loop: false,
    centerSlide: 'true',
    fade: 'true',
    grabCursor: 'true',
  });
}

function getModal() {
  var myModal = new bootstrap.Modal(document.getElementById("staticBackdrop"), {});
  myModal.show();

  var btn = document.getElementById("savepw");
  btn.addEventListener('click', function () {
    var pw1 = document.getElementById("pw");
    var pw2 = document.getElementById("pwagain");

    //check empty password field

    if (pw1.value == "") {
      document.getElementById("msg").innerHTML = "Bitte geben sie Ihr neues Passwort ein.";
      return;
    }

    //minimum password length validation
    if (pw1.value.length < 6) {
      document.getElementById("msg").innerHTML = "Das Passwort muss mindestens 6 Zeichen lang sein.";
      return;
    }

    //maximum length of password validation
    if (pw1.value.length > 30) {
      document.getElementById("msg").innerHTML = "Passwort darf maximal 30 Zeichen lang sein.";
      return;
    } else {
      if (pw1.value == pw2.value) {
        document.getElementById("msg").innerHTML = "Passwörter stimmen überein!";
        const requestData = {
          method: 'updateUser',
          pw: pw1.value
        };

        fetch('Components/updateUser.php', {
          method: 'POST',
          body: JSON.stringify(requestData),
          headers: {
            'Content-Type': 'application/json'
          }
        })
          .then(response => response.json())
          .then(data => {
            if (data["result"] == 1) {
              myModal.toggle();
            }
          })
          .catch(error => {
            console.error('Error:', error);
          });
      }

      else {
        document.getElementById("msg").innerHTML = "Passwörter stimmen nicht überein!";
        return;
      }
    }
  });
}

/*
function getModal(){
  fetch('Components/getModal.php')
  .then(response => response.text())
  .then(data => {
    document.body.innerHTML += data;
    var myModal = new bootstrap.Modal(document.getElementById("staticBackdrop"), {});
    myModal.show();

    var btn = document.getElementById("savepw");
    btn.addEventListener('click', function(){
      var pw1 = document.getElementById("pw");
      var pw2 = document.getElementById("pwagain");

      //check empty password field

      if(pw1.value == "") {
        document.getElementById("msg").innerHTML = "*Please put your new password!";
        return;
      } 

      //minimum password length validation
      if(pw1.value.length < 8) {
          document.getElementById("msg").innerHTML = "**Password length must be atleast 8 characters";
          return;
      }

      //maximum length of password validation
      if(pw1.value.length > 15) {
        document.getElementById("msg").innerHTML = "*Password length must not exceed 15 characters";
        return;
      } else {
        if(pw1.value == pw2.value){
            document.getElementById("msg").innerHTML=  "Passwords match!";
            const requestData = {
              method: 'updateUser',
              pw: pw1.value
            };
      
            fetch('Components/updateUser.php', {
              method: 'POST',
              body: JSON.stringify(requestData),
              headers: {
                'Content-Type': 'application/json'
              }
            })
            .then(response => response.json())
            .then(data => {
              if (data["result"] == 1){
                myModal.toggle();
              } 
            })
            .catch(error => {
              console.error('Error:', error);
            });
        }
      
        else {
            document.getElementById("msg").innerHTML=  "Passwords not match!";
            return;
        }
      }
    });
  })
  .catch(error => {
    console.error('Error:', error);
  });

}
*/