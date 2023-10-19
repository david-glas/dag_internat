<?php 
  if ($_SESSION["user"]["account"] != "webuser") 
  {
    if (in_array($_SESSION["user"]["account"], array("Admin", "Kantine"))) 
    {
      include("Pages/instructionsadmin.php");
    }
    if (in_array($_SESSION["user"]["account"], array("Schüler"))) 
    {
      include("Pages/instructionsstudent.php");
    }
  }
  elseif ($_SESSION["user"]["account"] == "webuser")
  {
    include("Pages/instructionswebuser.php");
  }
?>