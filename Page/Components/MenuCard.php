<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include "../Database/conn.php";
  $requestData = json_decode(file_get_contents('php://input'));

  if ($requestData->method == "getCardsByWeek") {
    $result = getCardsByWeek($requestData->week);
    echo $result;
  }
}
function nvl($var, $default = "")
{
  return isset($var) ? $var
    : $default;
}
function getLastMonday($week)
{
  $today = date('N'); // Gibt den aktuellen Wochentag als Zahl (1 für Montag, 7 für Sonntag) zurück

  if ($today === '1') {
    return strtotime("today + {$week} week");
  } else {
    return strtotime("last Monday + {$week} week");
  }
}

function getCurrentDay($lastMonday, $addedDays)
{
  return strtotime("+ {$addedDays} day", $lastMonday);
}

function tooLateToOrder($date)
{
  #return false;
  return $date >= strtotime("today + 7 days");
}

function getDateString($day, $index)
{

  $germanDays = array(
    0 => 'Montag',
    1 => 'Dienstag',
    2 => 'Mittwoch',
    3 => 'Donnerstag',
    4 => 'Freitag',
    5 => 'Samstag',
    6 => 'Sonntag'
  );

  return $germanDays[$index] . ' ' . date('d.m.Y', $day);
}

function getCardByUser($Meal, $day)
{
  $tooLate = tooLateToOrder($day);
  if (is_null($Meal["user_id"]) and !$tooLate) {
    return
      '<div class="card-body">
    <h5 id="xy" class="card-title">' . $Meal["type"] . '</h5>
    <p class="card-text">' . nvl($Meal["name"]) . '</p>
    <button type="button" class="btn btn-success custom-btn-size"  
        data-menu-id="' . nvl($Meal["menu_id"]) . '"
        data-user-id="1">
      Anmelden
    </button>
  </div>';
  } else if (!is_null($Meal["user_id"]) and !$tooLate) {
    return
      '<div class="card-body">
        <h5 id="xy" class="card-title">' . $Meal["type"] . '</h5>
        <p class="card-text">' . nvl($Meal["name"]) . '</p>
        <button type="button" class="btn btn-danger custom-btn-size"  
            data-menu-id="' . nvl($Meal["menu_id"]) . '"
            data-user-id="1">
          Abmelden
        </button>
      </div>';
  } else if (is_null($Meal["user_id"]) and $tooLate) {
    return
      '<div class="card-body">
        <h5 id="xy" class="card-title">' . $Meal["type"] . '</h5>
        <p class="card-text">' . nvl($Meal["name"]) . '</p>
        <button disabled type="button" class="btn btn-secondary custom-btn-size"  
            data-menu-id="' . nvl($Meal["menu_id"]) . '"
            data-user-id="1">
          nicht bestellt
        </button>
      </div>';
  } else if (!is_null($Meal["user_id"]) and $tooLate) {
    return
      '<div class="card-body">
        <h5 id="xy" class="card-title">' . $Meal["type"] . '</h5>
        <p class="card-text">' . nvl($Meal["name"]) . '</p>
        <button disabled type="button" class="btn btn-primary custom-btn-size"  
            data-menu-id="' . nvl($Meal["menu_id"]) . '"
            data-user-id="1">
          bestellt
        </button>
      </div>';
  }
}

function GetCardsByWeek($week)
{
  # 0 This Week, 1 Next Week, 2 Next Next Week
  $lastMonday = getLastMonday($week);
  $cards = "";
  for ($i = 0; $i < 5; $i++) {
    $currDate = getCurrentDay($lastMonday, $i);
    $day = getDateString($currDate, $i);
    $Menu = Menu::GetMenuByDateAndUser($currDate, 1);

    if (isset($Menu)) {
      $cards = $cards .
        '<div class="col">
          <div class="card">
            <div class="card-header">
              <small class="text-muted">' . $day . '</small>
              </div>' .
        getCardByUser($Menu->Breakfast, $day) . '<hr class="hr" />' .
        getCardByUser($Menu->Starter, $day) . '<hr class="hr" />' .
        getCardByUser($Menu->FirstMainMeal, $day) . '<hr class="hr" />' .
        getCardByUser($Menu->SecondMainMeal, $day) . '<hr class="hr" />' .
        getCardByUser($Menu->Dessert, $day) . '<hr class="hr" />' .
        getCardByUser($Menu->FirstDinner, $day) . '<hr class="hr" />' .
        getCardByUser($Menu->SecondDinner, $day) .
        '<div class="card-footer">
                  <small class="text-muted">' . $day . '</small>
                </div>
              </div>
            </div>';
    } else {
      $cards = $cards .
        '<div class="col">
          <div class="card">
            <div class="card-header">
              <small class="text-muted">' . $day . '</small>
                </div>
                <div class="card-body">
                  <h5 id="xy" class="card-title" data-meal-id="' . 'NoId' . '">Es wurde noch kein Essen hinzugefügt.</h5>
                </div>
                <div class="card-footer">
                  <small class="text-muted">' . $day . '</small>
                </div>
              </div>
            </div>';
    }

  }
  return $cards;
}
?>