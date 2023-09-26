<?php

include "conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode(file_get_contents('php://input'));

    if ($requestData->method == "addUserToMenu") {
        $result = addUserToMenu($requestData->menuId, $requestData->userId);
    } else if ($requestData->method == "removeUserFromMenu") {
        $result = removeUserFromMenu($requestData->menuId, $requestData->userId);
    }
    // Hier deine gewünschte Methode ausführen

    // Das Ergebnis als JSON zurückgeben
    echo json_encode(['result' => $result]);
}

function addUserToMenu($menuId, $userId)
{
    $Menu = new Menu();
    $Menu->AddUserToMenu($menuId, $userId);

    return 1;
}

function removeUserFromMenu($menuId, $userId)
{
    $Menu = new Menu();
    $Menu->RemoveUserFromMenu($menuId, $userId);

    return 1;
}


?>