<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap 5 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <title>Document</title>
</head>
<body>
  
</body>
</html>

<?php
include "Database/conn.php";

$user = new User();

#$user->AddUser("0205965818", "Horst", "Geberle", "saufen", 2);
$result = $user->CheckLogin("0205965818", "saufen");