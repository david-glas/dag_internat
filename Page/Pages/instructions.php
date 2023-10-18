<?php 
  if ($_SESSION["user"]["account"] != "webuser") 
  {
    if (in_array($_SESSION["user"]["account"], array("admin", "cantine"))) 
    {
      include("Pages/instructionsadmin.php");
    }
    if (in_array($_SESSION["user"]["account"], array("student"))) 
    {
      include("Pages/instructionsstudent.php");
    }
  }
  elseif ($_SESSION["user"]["account"] == "webuser")
  {
    include("Pages/instructionswebuser.php");
  }
?>