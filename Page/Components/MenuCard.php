<?php

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

function getCurrentDay($lastMonday, $addedDays){  
  return strtotime("+ {$addedDays} day", $lastMonday);
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

function GetCardsByWeek ($week){
   # 0 This Week, 1 Next Week, 2 Next Next Week
   $lastMonday = getLastMonday($week);
   $cards = "";
   for ($i = 0; $i < 5; $i++) {
     $currDate = getCurrentDay($lastMonday, $i);
     $string = getDateString($currDate, $i);
     $Menu = Menu::GetMenuByDate($currDate);

    if (isset($Menu))
    {
      $cards = $cards .
      '<div class="col">
          <div class="card">
            <div class="card-header">
              <small class="text-muted">' . $string . '</small>
                </div>
                <div class="card-body">
                  <h5 id="xy" class="card-title">Frühstück</h5>
                  <p class="card-text">' . nvl($Menu->Breakfast["name"]) . '</p>
                  <button id="btn" type="button" class="btn btn-success custom-btn-size"  
                      data-menu-id="' . nvl($Menu->Breakfast["menu_id"]) .'
                      data-user-id="' . "USERID" .'">
                    Anmelden
                  </button>
                </div>
              <hr class="hr" />
              <div class="card-body">
                  <h5 id="xy" class="card-title">Vorspeise</h5>
                  <p class="card-text">' . nvl($Menu->Breakfast["name"]) . '</p>
                  <button type="button" class="btn btn-success custom-btn-size"  
                      data-menu-id="' . nvl($Menu->Breakfast["menu_id"]) .'
                      data-user-id="' . "USERID" .'">
                    Anmelden
                  </button>
                </div>
              <hr class="hr" />
              <div class="card-body">
                  <h5 id="xy" class="card-title">1. Mittagessen</h5>
                  <p class="card-text">' . nvl($Menu->Breakfast["name"]) . '</p>
                  <button type="button" class="btn btn-success custom-btn-size"  
                      data-menu-id="' . nvl($Menu->Breakfast["menu_id"]) .'
                      data-user-id="' . "USERID" .'">
                    Anmelden
                  </button>
                </div>
              <hr class="hr" />
              <div class="card-body">
                  <h5 id="xy" class="card-title">2. Mittagessen</h5>
                  <p class="card-text">' . nvl($Menu->Breakfast["name"]) . '</p>
                  <button type="button" class="btn btn-success custom-btn-size"  
                      data-menu-id="' . nvl($Menu->Breakfast["menu_id"]) .'
                      data-user-id="' . "USERID" .'">
                    Anmelden
                  </button>
                </div>
              <hr class="hr" />
              <div class="card-body">
                  <h5 id="xy" class="card-title">Nachspeise</h5>
                  <p class="card-text">' . nvl($Menu->Breakfast["name"]) . '</p>
                  <button type="button" class="btn btn-success custom-btn-size"  
                      data-menu-id="' . nvl($Menu->Breakfast["menu_id"]) .'
                      data-user-id="' . "USERID" .'">
                    Anmelden
                  </button>
                </div>
              <hr class="hr" />
              <div class="card-body">
                  <h5 id="xy" class="card-title">1. Abendessen</h5>
                  <p class="card-text">' . nvl($Menu->Breakfast["name"]) . '</p>
                  <button type="button" class="btn btn-success custom-btn-size"  
                      data-menu-id="' . nvl($Menu->Breakfast["menu_id"]) .'
                      data-user-id="' . "USERID" .'">
                    Anmelden
                  </button>
                </div>
              <hr class="hr" />
              <div class="card-body">
                  <h5 id="xy" class="card-title">2. Abendessen</h5>
                  <p class="card-text">' . nvl($Menu->Breakfast["name"]) . '</p>
                  <button type="button" class="btn btn-success custom-btn-size"  
                      data-menu-id="' . nvl($Menu->Breakfast["menu_id"]) .'
                      data-user-id="' . "USERID" .'">
                    Anmelden
                  </button>
                </div>
                <div class="card-footer">
                  <small class="text-muted">' . $string . '</small>
                </div>
              </div>
            </div>';
    }
    else
    {
      $cards = $cards .
      '<div class="col">
          <div class="card">
            <div class="card-header">
              <small class="text-muted">' . $string . '</small>
                </div>
                <div class="card-body">
                  <h5 id="xy" class="card-title" data-meal-id="' . 'NoId' .'">' . 'No Meal' . '</h5>
                  <p class="card-text">This is card .</p>
                </div>
                <div class="card-footer">
                  <small class="text-muted">Last updated 3 mins ago</small>
                </div>
              </div>
            </div>';
    }

   }
   return $cards;
}
?>