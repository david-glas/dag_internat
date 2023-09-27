<?php
session_start();
$_SESSION["user"]["account"] = "webuser";
header("Location: ../index.php");
?>