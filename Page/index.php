<?php
include "Database/conn.php";

$user = new User();

#$user->AddUser("0205965818", "Horst", "Geberle", "saufen", 2);
$result = $user->CheckLogin("0205965818", "saufen");