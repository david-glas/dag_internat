<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include "../Database/conn.php";
  $requestData = json_decode(file_get_contents('php://input'));

  if ($requestData->method == "getCardsByWeek") {
    $result = getCardsByWeek($requestData->week);
    echo $result;
  } else if ($requestData->method == "getCardsByWeekAdmin") {
    $result = getCardsByWeekAdmin($requestData->week);
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
  return $date <= strtotime("today + 6 days");
}

function pastStyle($date)
{
  $arr = array(
    "card" => "",
    "header" => ""
  );
  if ($date < strtotime("today")) {
    $arr["card"] = 'style="background-color: rgba(196, 196, 196, 0.686);"';
    $arr["header"] = 'style="background-color:  rgb(196, 196, 196);"';
  }
  return $arr;
}

function isPast($date)
{
  if ($date < strtotime("today")) {
    return true;
  } else
    return false;
}

function getHeaderShade($date, $tooLate)
{
  if (is_null($tooLate)) {
    return 'id="emptyheader"';
  } else if ($tooLate) {
    if ($date == strtotime("today")) {
      return 'id="todayheader"';
    }
    return 'id="toolateheader"';
  }
  return 'id="normalheader"';
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

function emptyCard($day)
{

  return
    '<div class="swiper-slide">
      <div class="card">
        <div class="card-header" ' . getHeaderShade($day, null) . '>
          <small>' . $day . '</small>
        </div>
        <div id="past" class="card-body position-relative" data-ordered="0"></div>
        <hr class="hr" />
        <div id="past" class="card-body position-relative" data-ordered="0"></div>
        <hr class="hr" />
        <div id="past" class="card-body position-relative" data-ordered="0"></div>
        <hr class="hr" />
        <div id="past" class="card-body position-relative" data-ordered="0"></div>
        <hr class="hr" />
        <div id="past" class="card-body position-relative" data-ordered="0"></div>
        <hr class="hr" />
        <div id="past" class="card-body position-relative" data-ordered="0"></div>
        <hr class="hr" />
        <div id="past" class="card-body position-relative" data-ordered="0"></div>
        <div class="card-footer" ' . getHeaderShade($day, null) . '>
              <small>' . $day . '</small>
            </div>
        </div></div>';

}

function getCardByUser($Meal, $day, $tooLate)
{
  $button = "";
  $text = "";
  $card = '<div class="card-body position-relative"';

  if (is_null($Meal["user_id"]) and !$tooLate) {
    $card = '<div class="card-body position-relative"
              data-ordered="0"';
    if (is_null($Meal["food_id"])) {
      $button = '<button hidden name="userbutton" disabled type="menubutton" class="stretched-link" ';
    } else {
      $button = '<button name="userbutton" type="menubutton" class="stretched-link" ';
    }
  } else if (!is_null($Meal["user_id"]) and !$tooLate) {
    $card = '<div class="card-body position-relative" style="background-color: rgba(154, 211, 154, 0.51);"
              data-ordered="1"';
    $button = '<button name="userbutton" type="menubutton" class="stretched-link" ';
  } else if (is_null($Meal["user_id"]) and $tooLate) {
    $button = '<button hidden name="userbutton" disabled type="menubutton"
                class="btn btn-secondary stretched-link custom-btn-size" ';
    $card = '<div class="card-body position-relative" style="background-color: rgba(62, 61, 68, 0.1);"';
    $text = "nicht angemeldet";
  } else if (!is_null($Meal["user_id"]) and $tooLate) {
    $button = '<button hidden name="userbutton" disabled type="menubutton" class="btn btn-primary stretched-link custom-btn-size" ';
    $card = '<div class="card-body position-relative" style="background-color: rgba(173, 216, 230, 0.558);"';
  }

  $string =
    $card .
    'id="' . nvl($Meal["menu_id"]) . '">
    <h5 id="xy" class="card-title">' . $Meal["type"] . '</h5>
      <p class="card-text">' . nvl($Meal["name"]) . '</p>' .
    $button .
    'data-menu-id="' . nvl($Meal["menu_id"]) . '"
           data-meal-id="' . nvl($Meal["meal_id"]) . '"
           data-user-id="' . $_SESSION["user"]["userid"] . '">
    ' . $text . '
    </button>
    </div>';

  return $string;
}

function getCardByAdmin($Meal, $day, $Menu)
{
  $Food = Food::GetFoodByMeal($Meal["meal_id"], $Menu);
  $string =
    '<div class="card-body">
      <div id="dropi" class="dropdown-center">
        <button id="drop" class="btn btn-primary-outline dropdown-toggle  custom-btn-size" 
        type="menubutton" data-bs-toggle="dropdown" aria-expanded="false">
        ' . $Meal["type"] . ' (' . $Meal["amount"] . ')
        </button>
        <ul class="dropdown-menu dropdown-custom">';
  $string .= '<li><a id="drop" class="dropdown-item" type="button"
        data-menu-id="' . nvl($Meal["menu_id"]) . '" data-food-id="">Entfernen</a></li>';
  foreach ($Food as $entry) {
    $string .= '<li><a id="drop" class="dropdown-item" type="button"
          data-menu-id="' . nvl($Meal["menu_id"]) . '" data-food-id="' . nvl($entry["food_id"]) . '">'
      . $entry["name"] .
      '</a></li>';
  }
  $string .= '        
            </ul>
          </div>
          <p id="Menu' . nvl($Meal["menu_id"]) . '" class="card-text">' . nvl($Meal["name"]) . '</p>
        </div>';
  return $string;

}

function GetCardsByWeek($week)
{
  # 0 This Week, 1 Next Week, 2 Next Next Week
  $lastMonday = getLastMonday($week);
  $cards = "";
  $Menu = new Menu();
  for ($i = 0; $i < 5; $i++) {
    $currDate = getCurrentDay($lastMonday, $i);
    $tooLate = tooLateToOrder($currDate);
    $past = isPast($currDate);
    $day = getDateString($currDate, $i);
    $Menu = $Menu->GetMenuByDateAndUser($currDate, $_SESSION["user"]["userid"]);

    if ($past) {
      $cards = $cards . emptyCard($day);
    } else if (isset($Menu->Breakfast)) {
      $cards = $cards .
        '<div class="swiper-slide">
          <div class="card">
            <div class="card-header"' . getHeaderShade($currDate, $tooLate) . '>
              <small>' . $day . '</small>
              </div>' .
        getCardByUser($Menu->Breakfast, $currDate, $tooLate) . '<hr class="hr" />' .
        getCardByUser($Menu->Starter, $currDate, $tooLate) . '<hr class="hr" />' .
        getCardByUser($Menu->FirstMainMeal, $currDate, $tooLate) . '<hr class="hr" />' .
        getCardByUser($Menu->SecondMainMeal, $currDate, $tooLate) . '<hr class="hr" />' .
        getCardByUser($Menu->Dessert, $currDate, $tooLate) . '<hr class="hr" />' .
        getCardByUser($Menu->FirstDinner, $currDate, $tooLate) . '<hr class="hr" />' .
        getCardByUser($Menu->SecondDinner, $currDate, $tooLate) .
        '<div class="card-footer" ' . getHeaderShade($currDate, $tooLate) . '>
                  <small>' . $day . '</small>
                </div>
            </div></div>';
    } else {
      $cards = $cards . emptyCard($day);
    }

  }
  return $cards;
}

function GetCardsByWeekAdmin($week)
{
  # 0 This Week, 1 Next Week, 2 Next Next Week
  $lastMonday = getLastMonday($week);
  $cards = "";
  $Menu = new Menu();
  #Falls Performance schlecht, Food extra laden, und dann bei Cards von hier aus einfügen,
  #damit man in Cards nicht jedes mal zur DB muss.
  #$Food = Food::GetAllFoodByMeal($Menu);
  for ($i = 0; $i < 5; $i++) {
    $currDate = getCurrentDay($lastMonday, $i);
    $day = getDateString($currDate, $i);
    $past = isPast($currDate);
    $tooLate = tooLateToOrder($currDate);
    $Menu = $Menu->GetMenuByDateAdmin($currDate);

    if ($past) {
      $cards = $cards . emptyCard($day);
    } else if (isset($Menu->Breakfast)) {
      $cards = $cards .
        '<div class="swiper-slide">
        <div class="col">
        <div class="card">
          <div class="card-header" ' . getHeaderShade($currDate, $tooLate) . '>
              <small>' . $day . '</small>
              </div>' .
        getCardByAdmin($Menu->Breakfast, $day, $Menu) . '<hr class="hr" />' .
        getCardByAdmin($Menu->Starter, $day, $Menu) . '<hr class="hr" />' .
        getCardByAdmin($Menu->FirstMainMeal, $day, $Menu) . '<hr class="hr" />' .
        getCardByAdmin($Menu->SecondMainMeal, $day, $Menu) . '<hr class="hr" />' .
        getCardByAdmin($Menu->Dessert, $day, $Menu) . '<hr class="hr" />' .
        getCardByAdmin($Menu->FirstDinner, $day, $Menu) . '<hr class="hr" />' .
        getCardByAdmin($Menu->SecondDinner, $day, $Menu) .
        '<div class="card-footer" ' . getHeaderShade($currDate, $tooLate) . '>
                  <small>' . $day . '</small>
                </div>
              </div>
            </div></div>';
    } else {
      $cards = $cards .
        '<div class="swiper-slide">
      <div class="col">
      <div class="card">
      <div class="card-header" ' . getHeaderShade($currDate, $tooLate) . '>>
              <small>' . $day . '</small>
                </div>
                <div class="card-body">
                  <h5 id="xy" class="card-title" data-meal-id="' . 'NoId' . '">Es wurde noch kein Essen hinzugefügt.</h5>
                  <button name="addday" id="' . $currDate . '" type="button" class="btn btn-secondary custom-btn-size"  
                  data-date="' . $currDate . '">
                Hinzufügen
              </button>
                </div>
                <div class="card-footer" ' . getHeaderShade($currDate, $tooLate) . '>>
                  <small>' . $day . '</small>
                </div>
              </div>
              </div></div>';
    }
  }
  return $cards;
}
?>