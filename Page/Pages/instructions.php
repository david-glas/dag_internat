<div class="container mt-5 mr-3 ml-3">
  <h1 class="display-3">Instructions</h1>
  <p class="fs-5">
    Willkommen zur Anleitung für die Nutzung unserer Webapplikation zur Verwaltung 
    der Verpflegung für Internatsschüler. Diese Anleitung erklärt, wie verschiedene 
    Benutzergruppen die Funktionen der Anwendung nutzen können.
  </p>
</div>
<div class="container marketing mt-5">
<div class="row featurette mt-3">
  <div class="col-md-7">
    <h1 class="display-6">Schüler</h1>
    <p class="fs-5">
      Einem Benutzer wird nach dem Login die Menüseite gezeigt. Hier werden die aktuelle Woche und die nächsten zwei Wochen angezeigt. 
      Für jeden Tag werden die verfügbaren Mahlzeiten mit den zugehörigen Gerichten angezeigt. Die Anmeldung für eine Mahlzeit muss immer eine Woche im Voraus gemacht werden.
    </p>
    <p class="fs-5">
      Der heutige Tag ist <span style="color: orange">ORANGE</span>, Tage an denen sich der Benutzer nicht anmelden kann sind <span style="color: lightgrey">HELLGRAU</span> 
      und Tage an denen sich der Benutzer noch anmelden kann sind <span style="color: grey">GRAU</span> gefärbt.
    </p>
    <p class="fs-5">
      Um sich für eine Mahlzeit anzumelden kann der Benutzer einfach auf diese klicken. Die ausgewählte Mahlzeit wird farblich markiert.
    </p>
  </div>
  <div class="col-md-5">
    <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" src="assets/img/menu_instruction.png">
  </div>
</div>
<?php
  include("Pages\instructionsadmin.php");
?>
