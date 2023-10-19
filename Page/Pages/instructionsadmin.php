<style>
  .image-with-border {
    border: 1px solid black;
    width: 526px;
    height: 300px;
  }
</style>

<div class="container marketing mt-5">

  <h1 class="display-3">Anleitung für Administratoren</h1>

  <hr class="featurette-divider">
  <hr class="featurette-divider">

  <div class="row featurette mt-3">
    <div class="col-md-7 order-md-2">
      <h1 class="display-6">Neuen User anlegen</h1>
      <h5>1.</h5>
      <p class="fs-6">
        Im Dashboard kann man unter dem Reiter "Benutzer" neue User anlegen. Der <span style="color: red">ROTE</span> Pfeil zeigt auf einen Button.
      </p>
      <h5>2.</h5>
      <p class="fs-6">
        Nach dem betätigen dieses Buttons kommt seitlich ein Menü zum anlegen der User.
      </p>
    </div>
    <div class="col-md-5">
      <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto image-with-border" src="assets\img\newUser.png" id="imgNewUser" onclick="changeImage(this, 'badgeContainer1')">
      <div id="badgeContainer1"></div>
    </div>
  </div>

  <hr class="featurette-divider">

  <div class="row featurette mt-3">
    <div class="col-md-7">
      <h1 class="display-6">Userinformationen ändern</h1>
      <h5>1.</h5>
      <p class="fs-6">
        Der <span style="color: red">ROTE</span> Pfeil zeigt auf eine Dropbox die dann verschiedene Menüs enthält.
      </p>
      <h5>2.</h5>
      <p class="fs-6">
        Durch die Auswahl eines Gerichts können Sie eine Speise zuweisen.
      </p>
    </div>
    <div class="col-md-5">
      <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto image-with-border" src="assets\img\changeUser.png" id="imgChangeUser" onclick="changeImage(this, 'badgeContainer2')">
      <div id="badgeContainer2"></div>
    </div>
  </div>

  <hr class="featurette-divider">

  <div class="row featurette mt-3">
    <div class="col-md-7 order-md-2">
      <h1 class="display-6">Neue Speise anlegen</h1>
      <h5>1.</h5>
      <p class="fs-6">
        Im Dashboard kann man unter dem Reiter "Gerichte" neue Speisen anlegen. Der <span style="color: red">ROTE</span> Pfeil zeigt auf einen Button.
      </p>
      <h5>2.</h5>
      <p class="fs-6">
        Nach dem betätigen dieses Buttons kommt seitlich ein Menü zum anlegen der Speisen.
      </p>
    </div>
    <div class="col-md-5">
      <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto image-with-border" src="assets\img\newMeal.png" id="imgNewMeal" onclick="changeImage(this, 'badgeContainer3')">
      <div id="badgeContainer3"></div>
    </div>
  </div>

  <hr class="featurette-divider">

  <div class="row featurette mt-3">
    <div class="col-md-7">
      <h1 class="display-6">Menükarte befüllen</h1>
      <h5>1.</h5>
      <p class="fs-6">
        Der <span style="color: red">ROTE</span> Pfeil zeigt auf eine Dropbox die dann verschiedene Menüs enthält.
      </p>
      <h5>2.</h5>
      <p class="fs-6">
        Durch die Auswahl eines Gerichts können Sie eine Speise zuweisen.
      </p>
    </div>
    <div class="col-md-5">
      <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto image-with-border" src="assets\img\changeMeal.png" id="imgChangeMeal" onclick="changeImage(this, 'badgeContainer4')">
      <div id="badgeContainer4"></div>
    </div>
  </div>
  
  <hr class="featurette-divider">
  
  <div class="row featurette mt-3">
    <div class="col-md-7 order-md-2">
      <h1 class="display-6">Menükarte befüllen</h1>
      <h5>1.</h5>
      <p class="fs-6">
        Der <span style="color: red">ROTE</span> Pfeil zeigt auf eine Dropbox die dann verschiedene Menüs enthält.
      </p>
      <h5>2.</h5>
      <p class="fs-6">
        Durch die Auswahl eines Gerichts können Sie eine Speise zuweisen.
      </p>
      <h5>3.</h5>
      <p class="fs-6">
        
      </p>
    </div>
    <div class="col-md-5">
      <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto image-with-border" src="assets\img\changeMenue.png" id="imgChangeMenue" onclick="changeImage(this, 'badgeContainer5')">
      <div id="badgeContainer5"></div>
    </div>
  </div>
</div>



<script>

  document.addEventListener("DOMContentLoaded", function() {
    var initialBadgeValue = 1;
    changeNumber(initialBadgeValue, "badgeContainer1");
    changeNumber(initialBadgeValue, "badgeContainer2");
    changeNumber(initialBadgeValue, "badgeContainer3");
    changeNumber(initialBadgeValue, "badgeContainer4");
    changeNumber(initialBadgeValue, "badgeContainer5");
  });


  function changeImage(imgElement, badgeContainerId) {
    var x = 1
    if(imgElement.id == "imgNewUser"){
      if (imgElement.src.endsWith("newUser.png")) {
        imgElement.src = "assets\\img\\newUser2.png";
        x = 2;
      } else {
        imgElement.src = "assets\\img\\newUser.png";
        x = 1;
      }
    }else if(imgElement.id == "imgChangeUser"){
      if (imgElement.src.endsWith("changeUser.png")) {
        imgElement.src = "assets\\img\\changeUser2.png";
        x = 2;
      } else {
        imgElement.src = "assets\\img\\changeUser.png";
        x = 1;
      }
    }else if(imgElement.id == "imgNewMeal"){
      if (imgElement.src.endsWith("newMeal.png")) {
        imgElement.src = "assets\\img\\newMeal2.png";
        x = 2;
      } else {
        imgElement.src = "assets\\img\\newMeal.png";
        x = 1;
      }
    }else if(imgElement.id == "imgChangeMeal"){
      if (imgElement.src.endsWith("changeMeal.png")) {
        imgElement.src = "assets\\img\\changeMeal2.png";
        x = 2;
      } else {
        imgElement.src = "assets\\img\\changeMeal.png";
        x = 1;
      }
    }else if(imgElement.id == "imgChangeMenue"){
      if (imgElement.src.endsWith("changeMenue.png")) {
        imgElement.src = "assets\\img\\changeMenue2.png";
        x = 2;
      } else if(imgElement.src.endsWith("changeMenue2.png")){
        imgElement.src = "assets\\img\\changeMenue3.png";
        x = 3;
      } else {
        imgElement.src = "assets\\img\\changeMenue.png";
        x = 1;
      }
    }
    changeNumber(x, badgeContainerId);
  }

  function changeNumber(x, badgeContainerId) {
    var badgeContainer = document.getElementById(badgeContainerId);
    if (x == 1) {
      badgeContainer.innerHTML = '<span class="badge text-bg-warning" style="width: 27px; height: 25px; font-size: 15px; position: relative; bottom: 27px; left: 2px;">1</span>';
    } else if (x == 2) {
      badgeContainer.innerHTML = '<span class="badge text-bg-warning" style="width: 27px; height: 25px; font-size: 15px; position: relative; bottom: 27px; left: 2px;">2</span>';
    } else if (x == 3) {
      badgeContainer.innerHTML = '<span class="badge text-bg-warning" style="width: 27px; height: 25px; font-size: 15px; position: relative; bottom: 27px; left: 2px;">3</span>';
    }
  }
</script>