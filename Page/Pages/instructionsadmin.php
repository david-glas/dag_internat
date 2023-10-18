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
      <p class="fs-5">
        Im Dashboard kann man unter dem Reiter "Benutzer" neue User anlegen. Der <span style="color: red">ROTE</span> Pfeil zeigt auf einen Button.
      </p>
      <p class="fs-5">
        Nach dem betätigen dieses Buttons kommt seitlich ein Menü zum anlegen der User.
      </p>
      <p class="fs-5">
        Hier gibt man die gewünschten Informationen ein und bestätigt mit dem Button auf den der <span style="color: #ffc107">GELBE</span> Pfeil zeigt
      </p>
    </div>
    <div class="col-md-5">
      <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto image-with-border" src="assets\img\newUser.png" id="imgNewUser" onclick="changeImage(this)">
    </div>
  </div>

  <hr class="featurette-divider">

  <div class="row featurette mt-3">
    <div class="col-md-7">
      <h1 class="display-6">Userinformationen ändern</h1>
      <p class="fs-5">
        Der <span style="color: red">ROTE</span> Pfeil zeigt auf eine Dropbox die dann verschiedene Menüs enthält.
      <p class="fs-5">
        Durch die Auswahl eines Gerichts können Sie eine Speise zuweisen.
      </p>
      <p class="fs-5">
        
      </p>
    </div>
    <div class="col-md-5">
      <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto image-with-border" src="assets\img\changeUser.png" id="imgChangeUser" onclick="changeImage(this)">
    </div>
  </div>

  <hr class="featurette-divider">

  <div class="row featurette mt-3">
    <div class="col-md-7 order-md-2">
      <h1 class="display-6">Neue Speise anlegen</h1>
      <p class="fs-5">
        Im Dashboard kann man unter dem Reiter "Gerichte" neue Speisen anlegen. Der <span style="color: red">ROTE</span> Pfeil zeigt auf einen Button.
      </p>
      <p class="fs-5">
        Nach dem betätigen dieses Buttons kommt seitlich ein Menü zum anlegen der Speisen.
      </p>
      <p class="fs-5">
        Hier legt man die gewünschten Speise an und bestätigt mit dem Button auf den der <span style="color: #ffc107">GELBE</span> Pfeil zeigt
      </p>
    </div>
    <div class="col-md-5">
      <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto image-with-border" src="assets\img\newMeal.png" id="imgNewMeal" onclick="changeImage(this)">
    </div>
  </div>

  <hr class="featurette-divider">

  <div class="row featurette mt-3">
    <div class="col-md-7">
      <h1 class="display-6">Menükarte befüllen</h1>
      <p class="fs-5">
        Der <span style="color: red">ROTE</span> Pfeil zeigt auf eine Dropbox die dann verschiedene Menüs enthält.
      <p class="fs-5">
        Durch die Auswahl eines Gerichts können Sie eine Speise zuweisen.
      </p>
      <p class="fs-5">
        
      </p>
    </div>
    <div class="col-md-5">
      <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto image-with-border" src="assets\img\changeMeal.png" id="imgChangeMeal" onclick="changeImage(this)">
    </div>
  </div>
  
  <hr class="featurette-divider">
  
  <div class="row featurette mt-3">
    <div class="col-md-7 order-md-2">
      <h1 class="display-6">Menükarte befüllen</h1>
      <p class="fs-5">
        Der <span style="color: red">ROTE</span> Pfeil zeigt auf eine Dropbox die dann verschiedene Menüs enthält.
      <p class="fs-5">
        Durch die Auswahl eines Gerichts können Sie eine Speise zuweisen.
      </p>
      <p class="fs-5">
        
      </p>
    </div>
    <div class="col-md-5">
      <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto image-with-border" src="assets\img\changeMenue.png" id="imgChangeMenue" onclick="changeImage(this)">
      <span class="badge text-bg-warning">1</span>
    </div>
  </div>
</div>



<script>
  /*document.addEventListener('DOMContentLoaded', function () {
    var imgs = document.querySelectorAll("#img");
    imgs.forEach(function (img, index) {
      img.addEventListener('click', function(){
        let str = img.src;

        if (str.includes("2")) {
            // Remove the '2' if it's present
            str = str.replace("2", "");
        } else {
            // Insert '2' at the end of the string
            str = str.slice(0, str.lastIndexOf(".")) + "2" + str.slice(str.lastIndexOf("."));
        }

        img.src = str;
      });
    });
  });*/
  function changeImage(imgElement) {
    if(imgElement.id == "imgNewUser"){
      if (imgElement.src.endsWith("newUser.png")) {
        imgElement.src = "assets\\img\\newUser2.png";
      } else {
        imgElement.src = "assets\\img\\newUser.png";
      }
    }else if(imgElement.id == "imgChangeUser"){
      if (imgElement.src.endsWith("changeUser.png")) {
        imgElement.src = "assets\\img\\changeUser2.png";
      } else {
        imgElement.src = "assets\\img\\changeUser.png";
      }
    }else if(imgElement.id == "imgNewMeal"){
      if (imgElement.src.endsWith("newMeal.png")) {
        imgElement.src = "assets\\img\\newMeal2.png";
      } else {
        imgElement.src = "assets\\img\\newMeal.png";
      }
    }else if(imgElement.id == "imgChangeMeal"){
      if (imgElement.src.endsWith("changeMeal.png")) {
        imgElement.src = "assets\\img\\changeMeal2.png";
      } else {
        imgElement.src = "assets\\img\\changeMeal.png";
      }
    }else if(imgElement.id == "imgChangeMenue"){
      if (imgElement.src.endsWith("changeMenue.png")) {
        imgElement.src = "assets\\img\\changeMenue2.png";
      } else if(imgElement.src.endsWith("changeMenue2.png")){
        imgElement.src = "assets\\img\\changeMenue3.png";
      } else {
        imgElement.src = "assets\\img\\changeMenue.png";
      }
    }
  }
</script>
